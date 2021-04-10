<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return $this->sendError('please validate', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('zidan')->accessToken;
        $success['name'] = $user->name;
        return $this->sendResponse($success, 'User Registered Successfully');
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('zidan')->accessToken;
            $success['name'] = $user->name;
            return $this->sendResponse($success, 'User Logined Successfully');
        } else {
            return $this->sendError('Please Check Your Auth');
        }
    }

}


