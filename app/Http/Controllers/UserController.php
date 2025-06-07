<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class UserController extends Controller
{
     public function index(): View
    {
        $users = User::paginate(10);
        return view('users.index')->with('users', $users);
    }

    public function create(): View
    {
        $newUSer = new User();
        return view('users.create')->with('user', $newUSer);
    }

    public function store(Request $request): RedirectResponse
    {
        User::create($request->all());
        return redirect()->route('users.index');
    }

    public function edit(User $user): View
    {
        return view('users.edit')->with('user', $user);
    }
    public function update(Request $request, User $user): RedirectResponse
    {
        $user->update($request->all());
        return redirect()->route('users.index');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('users.index');
    }

    public function show(USer $user): View
    {
        return view('users.show')->with('user', $user);
    }
}
