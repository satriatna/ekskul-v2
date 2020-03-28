<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use Alert;
use Illuminate\Support\Facades\Hash;
class PengurusController extends Controller
{

    public function DaftarKanpengurus()
    {
        return view('pengurus/daftar');
    }
    public function dashboard_pengurus()
    {
        return view('pengurus/dashboard_pengurus');
    }

    /**
     * Get a validator for an incoming registration request.
    *
    * @param  array  $data
    * @return \Illuminate\Contracts\Validation\Validator
    */
   protected function validator(array $data)
   {
       return Validator::make($data, [
           'nama' => ['required', 'string', 'max:255'],
           'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           'password' => ['required', 'string', 'min:8', 'confirmed'],
       ]);
   }

   /**
    * Create a new user instance after a valid registration.
    *
    * @param  array  $data
    * @return \App\User
    */
   
   
}
