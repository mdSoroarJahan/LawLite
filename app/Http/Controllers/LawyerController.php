<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lawyer;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class LawyerController extends Controller
{
    /**
     * Display a listing of lawyers.
     */
    public function index(Request $request): View|ViewFactory
    {
        // Show seeded lawyers; if none, show an empty collection
        $lawyers = Lawyer::limit(20)->get();
        return view('lawyers.index', compact('lawyers'));
    }

    /**
     * Display a lawyer profile page.
     */
    public function show(int $id): View|ViewFactory
    {
        $lawyer = Lawyer::findOrFail($id);
        return view('lawyers.show', compact('lawyer'));
    }
}
