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
        $search = $request->input('search');

        $query = Lawyer::with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('expertise', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('bio', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $lawyers = $query->limit(50)->get();
        return view('lawyers.index', compact('lawyers'));
    }

    /**
     * Display a lawyer profile page.
     */
    public function show(int $id): View|ViewFactory
    {
        $lawyer = Lawyer::with('user')->findOrFail($id);
        return view('lawyers.show', compact('lawyer'));
    }
}
