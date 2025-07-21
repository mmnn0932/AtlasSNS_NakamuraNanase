<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('posts.index');
    }

    public function added() {
        return view('auth.added');
    }
}
