<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /* public function __construct()
    {
        $this->middleware('auth:api');
    } */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(10);

        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|string|max:191',
            'email'     => 'required|string|max:191|email|unique:users',
            'password'  => 'required|string|min:6',
            'type'      => 'required'
        ]);

        return User::create([
            'name'      => $request['name'],
            'email'     => $request['email'],
            'type'      => $request['type'],
            'bio'       => $request['bio'],
            'photo'     => $request['photo'],
            'password'  => Hash::make($request['password']),
        ]);
    }

    /**
     * Display the user profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return auth('api')->user();
    }

    /**
     * Update the user profile
     *
     * @param Request $request
     * @return void
     */
    public function updateProfile(Request $request)
    {
        // Verificando foto do perfil
        // pegando dados do usuário
        $user = auth('api')->user();

        // validando request
        $this->validate($request, [
            'name'      => 'required|string|max:191',
            'email'     => 'required|string|max:191|email|unique:users,email,'.$user->id,
            'password'  => 'sometimes|required|min:6',
        ]);

        // setando foto do usuário
        $currentPhoto = $user->photo;
        // se foto atual é diferente da anterior, realiza upload
        if ($request->photo != $currentPhoto) {
            // setando nome do arquivo
            $name = time().'.'.explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            // gravando imagem no banco
            Image::make($request->photo)->save(public_path(). '/img/profile/' . $name);
            // atribui nome da foto enviada no objeto request
            $request->merge(['photo' => $name]);
        }

        // verificando se o campo senha não está vazio
        if(!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        // atualiza usuário
        $user->update($request->all());
        return ['message' => "Success"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name'      => 'required|string|max:191',
            'email'     => 'required|string|max:191|email|unique:users,email,'.$user->id,
            'password'  => 'sometimes|min:6',
            'type'      => 'required'
        ]);

        $user->update($request->all());

        return ['message' => 'user updated!'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return ['message' => 'User Deleted'];
    }
}
