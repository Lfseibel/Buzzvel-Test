<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\SetupUserRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function setup(SetupUserRequest $request)
    {
      $credentials = ['email' => $request->email,
      'password' => $request->password];

      if(!Auth::attempt($credentials))
      {
          $user = new User();
  
          $user->name = $request->name;
          $user->email = $credentials['email'];
          $user->password = Hash::make($credentials['password']);
  
          $user->save();
  
          if(Auth::attempt($credentials))
          {
              $user = Auth::user();
  
              $masterToken = $user->createToken('master-token', ['create','read', 'update', 'delete']);
              $updateToken = $user->createToken('update-token', ['create', 'update']);
              $basicToken = $user->createToken('basic-token', ['read']);
            
              Auth::logout();
              return [
                  'master' => $masterToken->plainTextToken,
                  'update' => $updateToken->plainTextToken,
                  'basic' => $basicToken->plainTextToken
              ];
          }
      }
    }

}
