<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    protected function createToken($email, $password): array
    {

        try {
            if (! $token = auth('api')->attempt(['email' => $email, 'password' => $password])) {
                return ['success' => false, 'msg' => 'invalid credentials'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'msg' => $e->getMessage()];

        }

        return ['success' => true, 'token' => $token];
    }

    /**
     * Store a newly created user in storage and return a token session.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->save();

        $response = $this->createToken($validatedData['email'], $validatedData['password']);
        if (! $response['success']) {
            return response()->json(['error' => $response['msg']], 400);
        }

        return $this->respondWithToken($response['token']);
    }

    /**
     * Generate a new token for the session.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request = $request->validated();
        $response = $this->createToken($request['email'], $request['password']);
        if (! $response['success']) {
            return response()->json(['error' => $response['msg']], 400);
        }

        return $this->respondWithToken($response['token']);
    }

    /**
     * Return the user data from token session.
     */
    public function me(): JsonResponse
    {
        try {
            if (! $user = auth('api')->user()) {
                return response()->json(['error' => 'user_not_found'], 404);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($user);
    }

    /**
     * Destroy token session.
     */
    public function logout(): JsonResponse
    {

        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function createPassword(Request $request, User $user)
    {

        if (! $request->hasValidSignature()) {
            abort(401);
        }
        $response = $this->createToken($user->email, 'secret');
        if (! $response['success']) {
            return Redirect(env('FRONT_APP_URL'));
        }
        $token = $response['token'];
        return view('createPassword', compact('user', 'token'));
    }


    public function savePassword(RegisterRequest $request){
        $validated = $request->validated();
        $user = auth('api')->setToken($validated['Authorization'])->user();
        try {
            if (!$user) {

                return back()->with('error', __('User not found'));
            }
            $user = User::where('email', $user->email)->first();
            $user->password = Hash::make($validated['password']);
            $user->save();
        } catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }

        return redirect(env('FRONT_APP_URL'));
    }

    /**
     * Get the token array structure.
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }
}
