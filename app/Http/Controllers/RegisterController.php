<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //dd($request->get('username'));
        //dd($request);

        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'name' => 'required|min:3|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6|max:15',

        ]);

        /*
        * En esta version de Laravel automaticamente realiza el Hash al Password.
        * Si quisiera colocar Hash en algun dato de ingreso
        * 'password' => Hash::make($request->get('password')),
        */

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,

        ]);

        // Autenticar un usuario
        /*
        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);
        */
        // Otra manera de autentifcar
        auth()->attempt($request->only('email', 'password'));

        // Redireccionar
        return redirect()->route('posts.index', $request->username);
    }
}
