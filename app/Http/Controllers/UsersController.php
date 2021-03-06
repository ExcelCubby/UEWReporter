<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Hash;
use DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('manage.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('manage.users.create')->withRoles($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => ['nullable', 'digits:10'],
            'password' => ['required', 'confirmed'],
            'profile_picture' => 'image|nullable|max:1999'
        ]);
    
        $filenameToStore = "avatar.png";
        //Handle FIle Upload
        if($request->hasFile('profile_picture')){
            //Get FIlename with the extension
            $filenameWithExt = $request->file('profile_picture')->getClientOriginalName();
            //Get just Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just Ext
            $extension = $request->file('profile_picture')->getClientOriginalExtension();
            //Filename to Store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('profile_picture')->storeAs('public/profile_pictures', $filenameToStore);
        }
        else {
            $filenameToStore = "avatar.png";
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->profile_picture = $filenameToStore;
        $user->save();

        if ($user->save()){
            return redirect()->route('users.show', $user->id)->with('success', 'User Created Successfully');
        } 
        else {
            return redirect()->route('users.create')->with('danger', 'Sorry, a problem occured while creating the User');
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$role = Role::;
        $user = User::where('id', $id)->with('roles')->first();
        return view('manage.users.show')->withUser($user);//->withRole($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::all();
        $user = User::where('id', $id)->with('roles')->first();
        return view('manage.users.edit')->withUser($user)->withRoles($roles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => ['sometimes', 'digits:10'],
            'password' => ['confirmed'],
            'profile_picture' => 'image|nullable|max:1999'
        ]);

        //Handle FIle Upload
        if($request->hasFile('profile_picture')){
            //Get FIlename with the extension
            $filenameWithExt = $request->file('profile_picture')->getClientOriginalName();
            //Get just Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just Ext
            $extension = $request->file('profile_picture')->getClientOriginalExtension();
            //Filename to Store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('profile_picture')->storeAs('public/profile_pictures', $filenameToStore);
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if($request->hasFile('profile_picture')){
            $user->profile_picture = $filenameToStore;
        }
        
        if (!empty($request->password)) {
            $password = trim($request->password);
            $user->password = Hash::make($password);
        } 
        
        $user->save();
        
        
        if ($user->syncRoles(explode(',', $request->roles))) {
            return redirect()->route('users.show', $id)->with('success', 'User Details Updated Successfully');
        } 
        else {
            return redirect()->route('manage.users.edit', $user)->with('danger', 'Sorry, a problem occured while updating the User Details');
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
