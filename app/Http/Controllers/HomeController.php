<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function patientPortal()
    {
        return view('portals.patient');
    }

    public function professionalPortal()
    {
        return view('portals.professional');
    }
}
