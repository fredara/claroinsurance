<!DOCTYPE html>
<html>
<head>
    <title>Claro </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Crud To Claro </h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewUser"> Nuevo Usuario</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>ID Document</th>
                <th>Fecha de Nacimiento</th>
                <td>Edad</td>
                <td>Ciudad</td>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="ajaxModel" aria-hidden="trsue">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm" class="form-horizontal">
                   <input type="hidden" name="user_id" id="user_id">
                    <div class="alert alert-danger" id="msg_errors" style="display: none">
                        <ul id="ul-errors">
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="" maxlength="50" required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Contraseña</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" value="" maxlength="50" required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombres</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombres" value="" maxlength="100" required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="col-sm-2 control-label">Apellidos</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellidos" value="" maxlength="100" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">Telefono</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="phone" name="phone" placeholder="Telefono" value="" maxlength="11" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="document_id" class="col-sm-2 control-label">Dcoumento ID</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="document_id" name="document_id"  value="" maxlength="11" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fecha_nacimiento" class="col-sm-2 control-label">Fecha Nacimiento</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"  value="" maxlength="11" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Pais" class="col-sm-2 control-label">Pais</label>
                        <div class="col-sm-12">
                            <select id="pais" name="pais"  class="form-control">
                              <option selected value="">Seleccione...</option>
                              <?php 
                              use App\Pais;
                              $paises = Pais::all(); ?>
                              @foreach($paises as $pa)
                                <option id="{{ $pa->Codigo }}" value="{{ $pa->Codigo }}">{{ $pa->Pais }}</option>
                              @endforeach
                            </select>                        
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="Ciudad" class="col-sm-2 control-label">Ciudad</label>
                        <div class="col-sm-12">
                            <select id="ciudad" name="ciudad"  class="form-control" disabled>
                            </select>                        
                        </div>
                    </div>

                    
     
                    
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Guardar
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    
</body>
    
<script type="text/javascript">
  $(function () {

     

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'email', name: 'email'},
            {data: 'name', name: 'name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'phone', name: 'phone'},
            {data: 'document_id', name: 'document_id'},
            {data: 'fecha_nacimiento', name: 'fecha_nacimiento'},
            {data: 'edad', name: 'edad'},
            {data: 'Ciudad', name: 'Ciudad'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#pais').on('change',function(){
      var stateID = $(this).val();
      if(stateID){
          $.ajax({
              type:"GET",
              url:"{{ route('store') }}"+"/"+stateID+"/ciudad",
              data:"state_id="+stateID,
              success:function(html){
                  $('#ciudad').attr("disabled",false);
                  $('#ciudad').html(html);
                  
              }
          }); 
      }else{
          $('#ciudad').attr("disabled",true);
          $('#ciudad').html('<option value="">Select Primero el Pais</option>'); 
      }
    });

    $('#createNewUser').click(function () {
        $('#saveBtn').val("Crear User");
        $('#user_id').val('');
        $('#userForm').trigger("reset");
        $('#modelHeading').html("Crear Nuevo Usuario");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editUser', function () {
      var user_id = $(this).data('id');
      $.get("{{ route('index') }}" +'/' + user_id +'/edit', function (data) {
          $('#modelHeading').html("Editar User");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#user_id').val(data.id);
          $('#email').val(data.email);
          $('#name').val(data.name);
          $('#last_name').val(data.last_name);
          $('#phone').val(data.phone);
          $('#document_id').val(data.document_id);
          $('#fecha_nacimiento').val(data.fecha_nacimiento);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Enviando..');
    
        $.ajax({
          data: $('#userForm').serialize(),
          url: "{{ route('store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
            $('li').remove();
            if (data.success=='Validacion no Permitida') {
              var errores = data.error;
              $('#saveBtn').html('Guardar Cambios');
              //recorre el json para mostrar todos los errores de validacion que tenga
              for (var clave in errores){
                if (errores.hasOwnProperty(clave)) {
                  //console.log(errores[clave]);
                  $("#ul-errors").append( '<li id="breadcrumbs-li1" class="cambia estructura" >'+errores[clave]+'</li>');
                }
              }
              $("#msg_errors").css("display","block");
              
            }else{
              $("#msg_errors").css("display","none");
              $('#userForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              $('#saveBtn').html('Guardar Cambios');
              table.draw();
            }
     
              
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Guardar Cambios');
          }
      });
    });
    
    $('body').on('click', '.deleteUser', function () {
        var user = $(this).data("id");
        confirm("Está seguro que desea borrar !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('store') }}"+'/'+user,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
     
  });
</script>
</html>