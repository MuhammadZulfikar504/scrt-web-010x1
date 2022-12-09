<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

use App\Models\User;

use Carbon\Carbon;
use DataTables;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function getUsers(Request $req)
    {
        if ($req->ajax())
        {
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row)
                    {
                        $actionBtn = '<a href="users/show/' . $row->id . '" class="btn btn-sm btn-info">Info</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $req)
    {
        $req->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'gender' => ['required'],
            'birthdate' => ['required', 'date', 'before:today'],
            'religion' => ['required'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'max:20'],
            'username' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],
        [
            'username.required' => 'Username must be filled.',
            'username.unique' => 'Username is not available.',
            'birthdate.before' => 'Birthdate must before today.'
        ]);

        User::create([
            'fullname' => $req->fullname,
            'email' => $req->email,
            'gender' => $req->gender,
            'birthdate' => $req->birthdate,
            'religion' => $req->religion,
            'address' => $req->address,
            'phone' => $req->phone,
            'username' => $req->username,
            'password' => Hash::make($req->password),
        ]);

        return redirect('users');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $date = Carbon::parse($user->birthdate)->format('l, d F Y');

        return view('users.show', compact('user', 'date'));
    }

    public function update(Request $req)
    {
        $req->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'max:20'],
            'old_password' => ['required', Rules\Password::defaults()],
        ],
        [
            'old_password.required' => 'Masukkan password lama untuk mengedit data.'
        ]);

        $user = User::findOrFail($req->id);

        $user->fullname = $req->fullname;
        $user->address  = $req->address;
            
        if ($req->new_password != null)
        {
            $user->password = Hash::make($req->new_password);
        }

        $user->save();

        return redirect('users');
    }
}
