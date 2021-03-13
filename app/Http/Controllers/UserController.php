<?php

namespace App\Http\Controllers;

use App\User;
use App\Pais;
use App\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use Yajra\Datatables\Datatables;

use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            //Trae todos los usuarios
            $data = User::latest()->get();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Delete</a>';
    
                            return $btn;
                    })
                    ->addColumn('edad', function($row){
                        $fecha_nacimiento  = $row->fecha_nacimiento;
                        $edad = Carbon::parse($fecha_nacimiento )->age;
    
                        return $edad;
                    })
                    ->addColumn('Ciudad', function($row){
    
                        return $row->Ciudad['Ciudad'];
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('user',compact('users'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // carga lo creado (app/views/users/create.blade.php)
         return View::make('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $fecha_actual = Date("Y-m-d");//Obtiene la fecha actual
        $mifecha = explode("-",$fecha_actual);//Separa en array dia mes y año
        $añomenosquince = $mifecha[0]-15;//resta 15 al año 
        $lafecha = $añomenosquince."-".$mifecha[1]."-".$mifecha[2];//Unifica la fecha a comparar si es mayor a 15 formt 2021-03-11

        if ($request->user_id) {
            $user = User::find($request->user_id);
            $rules = array(
                'email'      => 'required|email|unique:users,email,'.$user->id,
                'password' => 'required|min:8|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
                'name'       => 'required|max:100',
                'last_name'       => 'required|max:100',
                'phone'       => 'min:8|max:11',
                'document_id'       => 'required|max:11|unique:users,document_id,'.$user->id,
                "fecha_nacimiento" => "required|date|before:".$lafecha,
            );
            //mensajes a las reglas 
            $messages = [
                'email.required' => 'Debe Ingresar un Correo.',
                'email.unique' => 'Ya Existe el correo para un Usuario.',
                'email.email' =>'No es Un Correo Valido',
                'password.required' => 'Debe Ingresar Contraseña',
                'password.min' => 'La Contraseña Debe Tener al menos 8 caracteres',
                'password.regex' => 'La Contraseña Debe Tener Al menos un Numero Un Caracter Especial y Una Mayuscula',
                'name.required' => 'Debe Ingresar Nombre',
                'name.max' => 'El Campo Nombres No Puede Pasar de 100 Caracteres',
                'last_name.required' => 'Debe Ingresar Apellido',
                'last_name.max' => 'El Campo Apellidos No Puede Pasar de 100 Caracteres',
                'phone.min' =>'El Telefono debe contener Minimo 8  Numeros',
                'phone.max' =>'El Telefono debe contener No mas de 11 Numeros',
                'document_id.required' => 'Debe Ingresar ID Documento.',
                'document_id.unique' => 'Ya Existe el ID para un Usuario.',
                'document_id.max' => 'ID no debe Pasar de 11 Digitos.',
                'fecha_nacimiento.required' => 'Debe Ingresar la Fecha de Nacimineto.',
                'fecha_nacimiento.before' => 'Debe Tener mas de 15 años de Edad.',
            ];

            $validator = Validator::make(Input::all(), $rules, $messages);

            // verifica validacion
            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json(['success'=>'Validacion no Permitida', 'error'=>$errors]);
            } else {
                
                    $user->email      = $request->email;
                    $user->password = bcrypt($request->password);
                    $user->name = $request->name;
                    $user->last_name = $request->last_name;
                    $user->phone = $request->phone;
                    $user->document_id = $request->document_id;
                    $user->fecha_nacimiento = $request->fecha_nacimiento;
                    $user->idCiudades = $request->ciudad;
                    $user->save();
                
       
                    return response()->json(['success'=>'Usuario Guardado.']);
                
                    // guardado
                
            }
            
        }else{

           
            
            //Validacion 
            //reglas
            $rules = array(
                'email'      => 'required|email|unique:users,email',
                'password' => 'required|min:8|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
                'name'       => 'required|max:100',
                'last_name'       => 'required|max:100',
                'phone'       => 'min:8|max:11',
                'document_id'       => 'required|max:12|unique:users,document_id',
                "fecha_nacimiento" => "required|date|before:".$lafecha,
            );
            //mensajes a las reglas 
            $messages = [
                'email.required' => 'Debe Ingresar un Correo.',
                'email.unique' => 'Ya Existe el correo para un Usuario.',
                'email.email' =>'No es Un Correo Valido',
                'password.required' => 'Debe Ingresar Contraseña',
                'password.min' => 'La Contraseña Debe Tener al menos 8 caracteres',
                'password.regex' => 'La Contraseña Debe Tener Al menos un Numero Un Caracter Especial y Una Mayuscula',
                'name.required' => 'Debe Ingresar Nombre',
                'name.max' => 'El Campo Nombres No Puede Pasar de 100 Caracteres',
                'last_name.required' => 'Debe Ingresar Apellido',
                'last_name.max' => 'El Campo Apellidos No Puede Pasar de 100 Caracteres',
                'phone.min' =>'El Telefono debe contener Minimo 8  Numeros',
                'phone.max' =>'El Telefono debe contener No mas de 11 Numeros',
                'document_id.required' => 'Debe Ingresar ID Documento.',
                'document_id.unique' => 'Ya Existe el ID para un Usuario.',
                'document_id.max' => 'ID no debe Pasar de 11 Digitos.',
                'fecha_nacimiento.required' => 'Debe Ingresar la Fecha de Nacimineto.',
                'fecha_nacimiento.before' => 'Debe Tener mas de 15 años de Edad.',
            ];

            $validator = Validator::make(Input::all(), $rules, $messages);

            // verifica validacion
            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json(['success'=>'Validacion no Permitida', 'error'=>$errors]);
            } else {
                
                    $user = new User;
                    $user->email      = $request->email;
                    $user->password = bcrypt($request->password);
                    $user->name = $request->email;
                    $user->last_name = $request->last_name;
                    $user->phone = $request->phone;
                    $user->document_id = $request->document_id;
                    $user->fecha_nacimiento = $request->fecha_nacimiento;
                    $user->idCiudades = $request->ciudad;
                    $user->save();
                
       
                return response()->json(['success'=>'Usuario Guardado.']);
                
                // guardado
                
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //trae el usuario
        $user = User::find($id);

        // redirecciona a la vista con los datos del usuario
        return View::make('users.show')
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

     public function ciudad($id)
    {
        $ciu='';
        $ciudades = Ciudad::where('Paises_Codigo', '=', $id)->get();
        if ($ciudades) {

            foreach ($ciudades as $ciud) {
                $ciu.= '<option value="'.$ciud->idCiudades.'">'.$ciud->Ciudad.'</option>';
            }
        }
        return $ciu;
        //return response()->json($ciudades);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //Validacion
        $rules = array(
            
            'id'       => 'unique:users',
            'email'      => 'required|email',
            'password' => 'required',
            'name'       => 'required',
            'last_name'       => 'required',

        );
        $validator = Validator::make(Input::all(), $rules);

        // verifica la validacion
        if ($validator->fails()) {
            return Redirect::to('users/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $user = User::find($id);
            $user->id       = Input::get('id');
            $user->email      = Input::get('email');
            $user->password = Input::get('password');
            $user->name = Input::get('name');
            $user->last_name = Input::get('last_name');
            $user->phone = Input::get('phone');
            $user->document_id = Input::get('document_id');
            $user->fecha_nacimiento = Input::get('fecha_nacimiento');
            $user->save();

            // redirect
            Session::flash('message', ' Actualizado correctamente user!');
            return Redirect::to('users');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success'=>'Usuario Eliminado Correctamente.']);
    }
}
