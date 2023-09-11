<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use App\Model\auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;

    }



    public function index()

    {
        if(Auth::check()){
            return view('layouts.Dash');
        }
        return view('auth.Login');
    }
}
