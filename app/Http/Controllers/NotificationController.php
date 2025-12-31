<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class NotificationController
 *
 * This controller is responsible for handling
 * Toastr notification messages such as success,
 * error, info, and warning.
 */
class NotificationController extends Controller
{
    /**
     * Display the toastr view page
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        // Load the toastr blade view
        return view('toastr');
    }

    /**
     * Redirect with a success toastr message
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function success() {
        // Redirect to /toastr with a success message in session
        return redirect('/toastr')->with('success', 'This is a success message!');
    }

    /**
     * Redirect with an error toastr message
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function error() {
        // Redirect to /toastr with an error message in session
        return redirect('/toastr')->with('error', 'This is an error message!');
    }

    /**
     * Redirect with an info toastr message
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function info() {
        // Redirect to /toastr with an info message in session
        return redirect('/toastr')->with('info', 'This is an info message!');
    }

    /**
     * Redirect with a warning toastr message
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function warning() {
        // Redirect to /toastr with a warning message in session
        return redirect('/toastr')->with('warning', 'This is a warning message!');
    }
}
