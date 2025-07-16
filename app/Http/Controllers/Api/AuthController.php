<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login(Request $request){
        $validator=Validator::make($request->all(),[ 'email' => 'required|email','password' => 'required']);
        if($validator->fails()) {
                   return response()->json(['status'=>false,'message'=>$validator->errors(),'data'=>[] ],400);       
           }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['status'=>false,'message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status'=>true,
            'message'=>'login success',
            'data'=>['token' => $token,'user' => $user]
           
        ]);
    }

    public function register(Request $request){
          $validator=Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'name'=>'required',
            'password' => 'required',
          ]);
          if($validator->fails()) {
                   return response()->json(['status'=>false,'message'=>$validator->errors(),'data'=>[] ],400);       
           }
          $user=  User::create(['name'=>$request->name,'email'=>$request->email,'password'=>Hash::make($request->password)]); 
           $token = $user->createToken('api-token')->plainTextToken;
             

        return response()->json([
            'status'=>true,
            'message'=>'register success',
            'data'=>[  'token' => $token,'user' => $user]],201 );
    }
}
?>