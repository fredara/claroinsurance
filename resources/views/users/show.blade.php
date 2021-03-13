<!DOCTYPE html>
<html>
<head>
    <title>Claro App</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('users') }}">user Alert</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('users') }}">View All users</a></li>
        <li><a href="{{ URL::to('users/create') }}">Create a user</a>
    </ul>
</nav>

<h1>Showing {{ $user->name }}</h1>

    <div class="jumbotron text-center">
        <h2>{{ $user->name }}</h2>
        <p>
            <strong>Email:</strong> {{ $user->email }}<br>
            <strong>Level:</strong> {{ $user->shark_level }}
        </p>
    </div>

</div>
</body>
</html>