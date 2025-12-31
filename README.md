# PHP_Laravel12_Add_Toastr_Notification


## Introduction

PHP_Laravel12_Add_Toastr_Notification is a beginner-friendly Laravel 12 project that demonstrates how to integrate Toastr notifications into a Laravel application.
Toastr is a lightweight JavaScript library used to display non-blocking alert messages that improve user experience by providing instant feedback.

This project focuses on a clean and simple implementation using Laravel session flash messages and CDN-based Toastr integration, without adding any extra packages or database dependency.


---


## Project Overview

The main goal of this project is to show how different types of notification messages can be displayed in Laravel 12, such as:

- Success notifications

- Error notifications

- Info notifications

- Warning notifications


---

## Key Objectives

* Integrate Toastr.js using CDN

* Trigger notifications using Laravel session flash messages

* Keep the implementation simple and easy to understand

* Avoid database usage for notifications

* Demonstrate a real-world UI feedback mechanism


---


## Technologies Used

* Laravel 12

* PHP

* Bootstrap 5

* Toastr.js

* HTML & Blade Templates


---


### Project Setup

## Step 1: Create Laravel 12 Project

```bash
composer create-project laravel/laravel PHP_Laravel12_Add_Toastr_Notification "12.*"
cd PHP_Laravel12_Add_Toastr_Notification
```

---


## Step 2: Environment Configuration

This project does **not require database configuration**.

Laravel requires a `.env` file for application settings such as `APP_KEY` and `APP_ENV`.
You can use the default `.env` file generated during project creation.

No database setup or migration is required for this project.


---


## Step 3: Install Toastr

You can use Toastr via CDN in Laravel Blade files.

Add this in resources/views/layouts/app.blade.php:

```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Toastr Notification</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    <div class="container mt-5">
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
        @if(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif
        @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif
    </script>
</body>
</html>
```

---


## Step 4: Create Routes

File: routes/web.php:

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/toastr', [NotificationController::class, 'index']);
Route::get('/success', [NotificationController::class, 'success']);
Route::get('/error', [NotificationController::class, 'error']);
Route::get('/info', [NotificationController::class, 'info']);
Route::get('/warning', [NotificationController::class, 'warning']);
```

---


## Step 5: Create Controller

```bash
php artisan make:controller NotificationController
```

File: app/Http/Controllers/NotificationController.php:

```php
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
```

---


## Step 6: Create Blade View

Create resources/views/toastr.blade.php:

```
@extends('layouts.app')

@section('content')
<div class="text-center">
    <h2>Laravel 12 Toastr Notifications Example</h2>
    <a href="/success" class="btn btn-success mt-3">Success</a>
    <a href="/error" class="btn btn-danger mt-3">Error</a>
    <a href="/info" class="btn btn-info mt-3">Info</a>
    <a href="/warning" class="btn btn-warning mt-3">Warning</a>
</div>
@endsection
```

---


## Step 7: Run Project

Run Project:

```bash
php artisan serve
```

Visit:

```
http://127.0.0.1:8000/toastr
```

Click the buttons to see Toastr notifications in action.

---


## Folder Structure

```
PHP_Laravel12_Add_Toastr_Notification/
│
├── app/
│   └── Http/
│       └── Controllers/
│           └── NotificationController.php
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       └── toastr.blade.php
│
├── routes/
│   └── web.php
│
├── public/
│   └── ...
│
├── .env
├── composer.json
└── README.md
```

---

## Output

**Toastr Success Notification**

<img width="1919" height="1028" alt="Screenshot 2025-12-31 123751" src="https://github.com/user-attachments/assets/4ad44c8f-c22e-41c9-bec9-49d0553a15c5" />


**Toastr Error Notification**

<img width="1916" height="1030" alt="Screenshot 2025-12-31 123805" src="https://github.com/user-attachments/assets/4c716ba3-08b3-43f7-a2cf-00b3cadbd48b" />


**Toastr Info Notification**

<img width="1919" height="1031" alt="Screenshot 2025-12-31 123813" src="https://github.com/user-attachments/assets/59a86206-1f42-4153-9ad9-c6428754af30" />


**Toastr Warning Notification**

<img width="1917" height="1030" alt="Screenshot 2025-12-31 123824" src="https://github.com/user-attachments/assets/f26e7752-db07-4ba7-89ba-55c59e20a490" />


---


Your PHP_Laravel12_Add_Toastr_Notification Project is Now Ready!
