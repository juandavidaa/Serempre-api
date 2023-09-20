<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\NewUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{


    /**
     * Update the specified resource in storage.
     */
    public function updateName(string $name): JsonResponse
    {
        $user = auth('api')->user();
        $user->name = $name;
        $user->save();
        return response()->json(['success' => true, 'msg' => "name successfully updated!"]);
    }

}
