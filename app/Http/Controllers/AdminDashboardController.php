<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{

    //View Admin Dashboard
    public function index(){
        return view('admin.dashboard');
    }
}