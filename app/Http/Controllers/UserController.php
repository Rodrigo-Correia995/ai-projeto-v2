<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class UserController extends Controller
{
     public function index(Request $request): View
    {
        $filterById = $request->query('id');
        $filterByNif = $request->query('nif');
        $filterByName = $request->query('name');

        $userQuery = User::query();

        if ($filterByName) {
            $userQuery->where('name', 'like', '%' . $filterByName . '%');
        }
        if ($filterById) {
            $userQuery->where('id', 'like', '%' . $filterById . '%');
        }
        if ($filterByNif) {
            $userQuery->where('nif', 'like', '%' . $filterByNif . '%');
        }

        $users = $userQuery->orderBy('id')->paginate(20)->withQueryString();

        return view('users.index', compact(
            'users',
            'filterByName',
            'filterById',
            'filterByNif',
        ));
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

    public function show(User $user): View
    {
        return view('users.show')->with('user', $user);
    }
}
