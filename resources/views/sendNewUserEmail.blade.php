<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>New User</title>



</head>
<body>
    <h1>Welcome {{ $user->name }} App!</h1>

    now you can create a new password here: <a href="{{ $createPasswordUrl }}">Create a Password</a>.<br />
    Once you create a new password. You will be able to Log In here: <a href="{{env('FRONT_APP_URL')}}">Serempre App</a>



</body>
</html>
