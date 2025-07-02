<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin(){
        $usersCount = User::all()->count();
        return view("admin.index", [
            'usersCount' => $usersCount
        ]);
    }

    public function laboran(){
        return view("laboran.index", [
            'page_meta' => [
                'page' => 'Dashboard'
            ]
        ]);
    }

    public function dashboardPengguna(){
        return view("pengguna.index", [
            'page_meta' => [
                'page' => 'Dashboard'
            ]
        ]);
    }
}
