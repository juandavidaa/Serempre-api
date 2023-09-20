<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>New User</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

</head>
<body>

<div class="container">
    <h1>Welcome {{ $user->name }}!</h1>


    <form action="{{route('api.savePassword')}}" method="POST">
        @csrf
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="Authorization" value="{{$token}}">

        <div class="form-group">
            <label for="password">Nueva contraseña</label>
            <input type="password" name="password" class="form-control">

        </div>
        <div class="form-group">

            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <button type="submit" class="btn btn-outline-primary">Crear Contraseña</button>
    </form>

</div>



</body>
</html>
