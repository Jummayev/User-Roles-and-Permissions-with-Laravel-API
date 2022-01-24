<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Register New User
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     * @return \Illuminate\Http\Response
     */
    public function user_register(Request $request){

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required_with:password|same:password|min:8',
            'phone_number' => 'required|string|min:7|max:15|unique:users',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 403);
        }
        $user = User::create(array(
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'password' => Hash::make($request->input('password')),
        ));
        return $user;


//            $new_student->password = Hash::make($request->password);
//        ;
//            $token = auth()->login($new_student);
//            $userData = User::where('id', $new_student->id)->get()->first();
//            return response([
//                'token' => $token,
//                'user' => $userData,
//            ]);
//        }

    }
}
