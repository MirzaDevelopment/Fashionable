<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class CreateAdminController extends Controller
{
    //Used to create the first admin user filled with appropriate credentials
    public function createAdmin():void
    {

   
     /*    User::create([
        'name' => "",
        'email' => "",
        'password' => Hash::make(""),
        'role'=>"Admin",
    ]);*/
}
}
