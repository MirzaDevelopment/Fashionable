<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //To display the number of registered users in admin dashboard
    public function countUsersAndProducts(){
     //Active products and users 
    $usersCount = User::count();
    $productsCount=Product::count();
    //Deleted products and users
    $deletedUsersCount=User::onlyTrashed()->count();
    $deletedProductsCount=Product::onlyTrashed()->count();

    Gate::authorize('create', Product::class);
    return view('dashboard')->with(["usersCount" => $usersCount, "productsCount" => $productsCount, "deletedUsersCount"=>$deletedUsersCount, "deletedProductsCount"=>$deletedProductsCount]);
    }
}
