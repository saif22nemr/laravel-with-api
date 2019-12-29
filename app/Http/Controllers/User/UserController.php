<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Mail\UserCreated;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user =User::all();
        return $this->showAll($user);
        //return response()->json(['data'=>$user],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $role = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
        //return $request;
        $val = $this->validate($request,$role);
        $data = $request->all();

        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generatorVerificationCode();
        $data['admin'] = User::REGULER_USER;
        $user = User::create($data);
        return $this->showOne($user);
        //return response()->json(['data'=>$user],201); // [201] => mean is created
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        //$user = User::findOrFail($id);
        return $this->showOne($user);
        //return response()->json(['data'=>$user],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::findOrFail($id);
        $roles = [
            'email' => 'email|unique:user,email,'.$user->id,
            'password' =>'min:6|confirmed',
            'admin' =>'in:'.User::ADMIN_USER.','.User::REGULER_USER
        ];
        if($request->has('name')){
            $user->name = $request->name;
        }
        if($request->has('email') and $user->email != $request->email){
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generatorVerificationCode();
            $user->email = $request->email;
        }
        if($request->has('password')) $user->password = bcrypt($request->password);
        if($request->has('admin')){
            if(!$user->isVerified())
                return response()->json(['error'=>'Only vereified users can be admin','code'=> 409],409); //409 ==> for error
            $user->admin = $request->admin;
        }
        //return $request->all();
        if(!$user->isDirty()){ //[isDirty] => if this user is change data{

            return response()->json(['error'=>'You need to update data','data'=>$user,'code'=> 422],422);
        }
        $user->save();
        return $this->showOne($user);
        //return response()->json(['data'=>$user],200);
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
        $user = User::findOrFail($id);
        $user->delete();
        return $this->showOne($user);
        //return response()->json(['data'=>$user],200);
    }
    public function verifiy($token){
        $user = User::where('verification_token',$token)->firstOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->save();

        return $this->showMessage('The account has been verified successfully!');
    }
    public function resend(User $user){
        if($user->verified == User::VERIFIED_USER)
            return $this->errorResponse('Your mail is already verified successfully',409);
        Mail::to($user)->send(new UserCreated($user));
        return $this->showMessage('Your account has been verified successfully!');
    }
}
