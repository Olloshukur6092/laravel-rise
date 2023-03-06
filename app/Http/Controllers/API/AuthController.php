<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), $this->rules());

    //     if ($validator->fails()) {
    //         return $this->sendError('Validator errors. ', $validator->errors(), 422);
    //     }

    //     $input = $request->all();
    //     $input['password'] = bcrypt($input['password']);
    //     $user = User::create($input);
    //     $success['token'] =  $user->createToken('RiseProject')->accessToken;
    //     $success['name'] =  $user->name;

    //     return $this->sendResponse($success, 'User register successfully.');
    // }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return $this->sendError('Validator errors.', $validator->errors(), 422);
        } else {

            $user = User::query()->where(['email' => $request->email])->first();

            if (!$user) {
                return $this->sendError('error. ', ['error' => 'User not found.'], 404);
            } else {
                if (!Hash::check($request->password, $user->password)) {
                    return $this->sendError('error. ', ['error' => 'User not found'], 404);
                } else {
                    $success['token'] = $user->createToken('token')->plainTextToken;
                    $success['name'] = $user->name;
                    return $this->sendResponse($success, 'User login successfully');
                }
            }
        }
    }

    public function logout(Request $request)
    {
        // if ($request->user()) {
        //     return 'salom';
        // } else {
        //     return 'yoq akan';
        // }
        $request->user()->tokens()->delete();
        return $this->sendResponse('success. ', 'Logout Successfully');
    }

    protected function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    protected function messages()
    {
        return [];
    }
}
