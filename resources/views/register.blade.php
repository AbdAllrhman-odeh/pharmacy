<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="{{route('create')}}">
        @csrf
        Enter  your naem:
        <input type="text" name="name">
        <br><br>
        Enter  your role:
        <input type="text" name="role">
        <br><br>
        Enter your email:
        <input type="email" name="email">
        <br><br>
        Enter your password:
        <input type="password" name="password">
        <br><br>
        <input type="submit" value="add">
    </form>
</body>
</html>