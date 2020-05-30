<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Hobby;
use Auth;

class UserController extends Controller
{    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::latest()->paginate(10);
        return response()->json(['user'=>$user]);
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
        $user = new User;
        $user->name=$request->name;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

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
        $user = User::with('hobbies')->find($user->id);
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
        ]);
        $user = User::find($id);

        $user->name=$request->name;
        $user->email = $request->email;
        if($request->password){
            $user->password = \Hash::make($request->password);
        }
        $user->save();
        return response()->json(['message'=>"Updated"]);
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|string|max:100',
            'email'=>'required|string|email|max:100|unique:users,email,'.Auth::user()->id,
        ]);
        $user = Auth::user();

        $user->name=$request->name;
        $user->email = $request->email;
        $user->about = $request->about;
        if($request->password){
            $user->password = \Hash::make($request->password);
        }

        $hobbies_ids = $this->storeHobby($request->hobbies);
        
        $user->hobbies()->sync($hobbies_ids);

        $user->save();

        return response()->json(['message'=>"Updated"]);
    }

    private function storeHobby($hobbies){
        $hobby_ids=[];
        foreach($hobbies as $h){
            $d=[];
            $d['name'] = $h['name'];
            $d['code'] = $h['code'];
            array_push($hobby_ids, Hobby::firstOrCreate($d)->id);
        }
        return $hobby_ids;        
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
