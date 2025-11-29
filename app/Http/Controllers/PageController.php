<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class PageController extends Controller
{
    /**
     * Show the About Us page.
     */
    public function about(): View|ViewFactory
    {
        return view('pages.about');
    }

    /**
     * Show the Contact page.
     */
    public function contact(): View|ViewFactory
    {
        return view('pages.contact');
    }

    /**
     * Show the Privacy Policy page.
     */
    public function privacy(): View|ViewFactory
    {
        return view('pages.privacy');
    }
}
