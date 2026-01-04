<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class AdminController extends Controller
{
    public function dashboard(): View|ViewFactory
    {
        return view('admin.dashboard');
    }
}
