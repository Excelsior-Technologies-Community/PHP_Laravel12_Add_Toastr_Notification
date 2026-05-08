<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index() 
    {
        return view('toastr');
    }

    public function success() 
    {
        return redirect('/toastr')->with('success', 'This is a success message!');
    }

    public function error() 
    {
        return redirect('/toastr')->with('error', 'This is an error message!');
    }

    public function info() 
    {
        return redirect('/toastr')->with('info', 'This is an info message!');
    }

    public function warning() 
    {
        return redirect('/toastr')->with('warning', 'This is a warning message!');
    }
}