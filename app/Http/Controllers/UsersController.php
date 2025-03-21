<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    //
    public function index() {
        return view('../posts/index');
    }

    public function added() {
        return view('/added');
    }

    public function login() {
        return view('/login');
    }
}
