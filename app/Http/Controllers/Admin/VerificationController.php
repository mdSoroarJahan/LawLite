<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class VerificationController extends Controller
{
    public function index(Request $request): View|ViewFactory
    {
        // list all lawyers that requested verification
        $lawyers = \App\Models\Lawyer::whereIn('verification_status', ['requested', 'pending'])->with('user')->get();
        return view('admin.verification.index', compact('lawyers'));
    }

    public function approve(Request $request, int $id)
    {
        $lawyer = \App\Models\Lawyer::findOrFail($id);
        $lawyer->verification_status = 'verified';
        $lawyer->save();
        return redirect()->back()->with('status', 'Lawyer verified');
    }

    public function reject(Request $request, int $id)
    {
        $lawyer = \App\Models\Lawyer::findOrFail($id);
        $lawyer->verification_status = 'rejected';
        $lawyer->save();
        return redirect()->back()->with('status', 'Verification rejected');
    }

    public function show(int $id)
    {
        $lawyer = \App\Models\Lawyer::with('user')->findOrFail($id);
        return view('admin.verification.show', compact('lawyer'));
    }

    public function requestInfo(Request $request, int $id)
    {
        $lawyer = \App\Models\Lawyer::findOrFail($id);
        $lawyer->verification_status = 'request_info';
        $lawyer->save();

        // Optional: Send notification to lawyer

        return redirect()->back()->with('status', 'Requested more info from lawyer');
    }
}
