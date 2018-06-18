<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use DatabaseTransactions;

    public $successCode = 200;

    /**
     * Login User
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('LaravelApp')->accessToken;
            return response()->json(['success' => $success], $this->successCode);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Register new user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->error()], 401);
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $success['token'] = $user->createToken('LaravelApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success' => $success], $this->successCode);
    }

    /**
     * Get Details User Information
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(){
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successCode);
    }
}
