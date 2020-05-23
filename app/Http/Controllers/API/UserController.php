<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
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
            'name'=>'required|string|max:100',
            'email'=>'required|string|email|max:100|unique:users',
            'password'=>'required|min:5|max:50'
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>\Hash::make($request->password),
            'role'=>$request->role
        ]);
        return response()->json(['user'=>$user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = \Auth::user();

        return response()->json(['user'=>$user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json(['user'=>$user]);
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
            'name'=>'required|string|max:100',
            'email'=>'required|string|email|max:100|unique:users,email,'.$id,
            'password'=>'sometimes|min:5|max:50'
        ]);
        $user = User::find($id);

        $user->name=$request->name;
        $user->email = $request->email;
        if($request->password){
            $user->password = \Hash::make($request->password);
        }
        // $user->role = $request->role;
        $user->save();

        return response()->json(['message'=>"Updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message'=>"User Deleted"]);
    }
}
