<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class UserController extends Controller
{
    /** @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View */
    public function index(): View|ViewFactory
    {
        // support search and role filter
        $qRaw = request()->input('q', '');
        $q = (is_scalar($qRaw) || $qRaw === null) ? strval($qRaw) : '';
        $roleRaw = request()->input('role', '');
        $role = (is_scalar($roleRaw) || $roleRaw === null) ? strval($roleRaw) : '';

        $query = User::query();
        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            });
        }
        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->orderBy('id', 'desc')->paginate(20);
        return view('admin.users.index', compact('users', 'q', 'role'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id): View|ViewFactory
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        /** @var array{name: string, email: string, role: string, language_preference?: string|null, password?: string|null} $data */
        $data = (array) $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|in:user,lawyer,admin',
            'language_preference' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = strval($data['name']);
        $user->email = strval($data['email']);
        $user->role = strval($data['role']);
        $user->language_preference = $data['language_preference'] ?? $user->language_preference;
        if (! empty($data['password'])) {
            $user->password = Hash::make(strval($data['password']));
        }
        $user->save();

        return Redirect::route('admin.users.index')->with('status', 'User updated');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('status', 'User deleted');
    }
}
