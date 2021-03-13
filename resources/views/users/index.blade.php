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

<h1>All the users</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Email</td>
            <td>user Level</td>
            <td>Actions</td>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->email }}</td>

            <!-- we will also add show, edit, and delete buttons -->
            <td>

                <!-- delete the shark (uses the destroy method DESTROY /users/{id} -->
                <!-- we will add this later since its a little more complicated than the other two buttons -->
                {{ Form::open(array('url' => 'users/' . $value->id, 'class' => 'pull-right')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete this shark', array('class' => 'btn btn-warning')) }}
                {{ Form::close() }}

                <!-- Mostrar User (uses the show method found at GET /users/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('users/' . $value->id) }}">Mostrar Este Usuario</a>

                <!-- editar este usuario (usa para editar el metodo  GET /users/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('users/' . $value->id . '/edit') }}">Editar</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</div>
</body>
</html>