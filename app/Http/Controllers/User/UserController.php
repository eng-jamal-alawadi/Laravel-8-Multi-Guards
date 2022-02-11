<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|',
            'confirmPassword' => 'required|same:password',
        ]);
        if (!$validator->fails()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $isSaved = $user->save();

            return response()->json([
                'message' => 'User created successfully',
            ], Response::HTTP_CREATED);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:'
        ]);

        if (!$validator->fails()) {
            $credintials = $request->only('email', 'password');
            if (Auth::guard('web')->attempt($credintials)) {
                return response()->json([
                    'message' => 'User login successfully',
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'Invalid email or password',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(){
        Auth::guard('web')->logout();
        return redirect('/');
    }
}




