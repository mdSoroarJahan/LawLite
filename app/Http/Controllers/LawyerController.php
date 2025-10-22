<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lawyer;

class LawyerController extends Controller
{
    /**
     * Display a listing of lawyers.
     */
    public function index(Request $request)
    {
        // Show seeded lawyers; if none, show an empty collection
        $lawyers = Lawyer::limit(20)->get();
        return view('lawyers.index', compact('lawyers'));
    }

    /**
     * Display a lawyer profile page.
     */
    public function show($id)
    {
        $lawyer = Lawyer::find($id);
        if (!$lawyer) {
            abort(404, 'Lawyer not found');
        }
        return view('lawyers.show', compact('lawyer'));
    }
}
