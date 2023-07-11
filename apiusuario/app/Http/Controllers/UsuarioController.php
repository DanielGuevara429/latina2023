<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios=Usuario::all();
        return $usuarios;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $usuario= new Usuario();
       $usuario->nombres=$request->nombres;
       $usuario->apellidos=$request->apellidos;
       $usuario->correo=$request->correo;
       $usuario->password=$request->password;
       $usuario->fechaNacimiento=$request->fecha;

       $correoExistente= Usuario::where('correo',$request->correo)->first();

       if($correoExistente)
       {

        $response=[
            'mensage'=>'El correo ya esta registrado'     
        ];
       }else{

        $usuario->save();

       $jsonString=json_encode($usuario,JSON_PRETTY_PRINT);

       $rutaArchivo=public_path('bucket\datos'.$usuario->correo.'.json');


       file_put_contents($rutaArchivo,$jsonString);

       $response=[
        'mensage'=>'Usuario creado correctamente y arhivo json generado',
         'usuario'=>$usuario
    ];

       }
    
       
    


       return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       
    }


    
        
        public function updatePassword(Request $request,$correo)

        {

            $usuario= Usuario::where('correo',$correo)->first();

            $data=json_decode($request->getContent());
       
            $usuario->password=$data->password;
        
        
         
        $usuario->save();
        
        $response=[
            'mensage'=>'Usuario actualizado correctamente',
             'usuario'=>$usuario
        ];
 
 
        return response()->json($response);

       
    
       //
    }


    public function login(Request $request){
        $response=["status"=>0,"mensage"=>""];

        $data=json_decode($request->getContent());
        $usuario= Usuario::where('correo',$data->correo)->first();

        if($usuario){
            if($data->password==$usuario->password){
                $response["status"]=1;
                $response["mensage"]="Bienvenido";
            }else{
                $response["mensage"]="Correo o contraseña incorrectos";
            }
        }else{
            $response["mensage"]="Usuario no encontrado";
        }

        return response()->json($response);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
