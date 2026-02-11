<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\AdminActivityNotification;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Auth;
use Session;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    $myRole = strtolower(auth()->user()->role->role_name ?? '');

    $query = User::with('role')->orderBy('id', 'DESC');

    if ($myRole === 'viewer') {
        $query->whereHas('role', function ($q) {
            $q->where('role_name', 'viewer');
        });
    }

    $users = $query->get();

    return view('admin.user.all', compact('users'));

    }

    public function add()
    {
        $roles = Role::all();
        return view ('admin.user.add', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|max:15',
            'email' => 'required|email|unique:users,email',
            'username' => 'required',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoName = null;

        if($request->hasFile('photo')){
            $file = $request->photo;
            $extension = $file->getClientOriginalExtension();
            $photoName = 'user_'.time().'_'.uniqid(30).'.'.$extension;
            $file->move(public_path('uploads/users'), $photoName);
        }

        $slug = 'user_'.uniqid(20);
        $creator = Auth::id();

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => 1,
            'slug' => $slug,
            'creator' => $creator,
            'photo' => $photoName,
            'created_at' => Carbon::now(),
        ]);

        if (Auth::check()) {
            Auth::user()->notify(new AdminActivityNotification(
                title: "New user added: {$user->name}",
                subtitle: "User created successfully",
                url: url("dashboard/user/view/".$user->slug),
                icon: "🆕"
            ));
        }

        return redirect()->route('dashboard.index')->with('success', 'User added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
    $myRole = strtolower(auth()->user()->role->role_name ?? '');

    $user = User::with('role')->where('slug', $slug)->firstOrFail();

    if ($myRole === 'viewer' && strtolower($user->role->role_name ?? '') !== 'viewer') {
        abort(403, 'Unauthorized');
    }

    return view('admin.user.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
public function edit($slug)
{
    $data = User::with('role')->where('slug', $slug)->firstOrFail();

    $myRole     = strtolower(auth()->user()->role->role_name ?? '');
    $targetRole = strtolower($data->role->role_name ?? '');

    if ($myRole === 'manager' && $targetRole === 'admin') {
        return redirect()->route('dashboard.user.index')
            ->with('error', 'Manager cannot edit Admin account.');
    }

    $roles = Role::all();

    return view('admin.user.edit', compact('data', 'roles'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
{
    $user = User::with('role')->where('slug', $slug)->firstOrFail();

    $myRole     = strtolower(auth()->user()->role->role_name ?? '');
    $targetRole = strtolower($user->role->role_name ?? '');


    if ($myRole === 'manager' && $targetRole === 'admin') {
        return redirect()->route('dashboard.user.index')
            ->with('error', 'Manager cannot update Admin account.');
    }

    $rules = [
        'name'   => 'required|string|max:255',
        'phone'  => 'nullable|max:15',
        'email'  => 'required|email|unique:users,email,' . $user->id,
        'status' => 'required|in:0,1',
        'photo'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    if ($myRole === 'admin') {
        $rules['role_id'] = 'required|exists:roles,id';
    }

    $request->validate($rules);

    // Photo Upload Logic
    if ($request->hasFile('photo')) {
        if ($user->photo && file_exists(public_path('uploads/users/'.$user->photo))) {
            unlink(public_path('uploads/users/'.$user->photo));
        }

        $file = $request->photo;
        $extension = $file->getClientOriginalExtension();
        $photoName = 'user_'.time().'_'.uniqid(30).'.'.$extension;
        $file->move(public_path('uploads/users'), $photoName);

        $user->photo = $photoName;
    }

    $user->name   = $request->name;
    $user->phone  = $request->phone;
    $user->email  = $request->email;
    $user->status = $request->status;
    $user->editor = Auth::id();

    if ($myRole === 'admin') {
        $user->role_id = $request->role_id;
    }

    $user->save();

    return redirect()->route('dashboard.user.index')->with('success', 'User Updated Successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->firstOrFail();

        if(auth()->id() == $user->id){
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();

        Auth::user()->notify(new AdminActivityNotification(
            title: "User deleted: {$user->name}",
            subtitle: "User deleted successfully",
            url: url("dashboard/user/view/".$user->slug),
            icon: "🗑️"
        ));

        return redirect()->route('dashboard.index')
        ->with('success', 'User deleted successfully');
    }

    public function softdelete()
    {
        //
    }
}
