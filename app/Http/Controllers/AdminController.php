<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:admins,email',
            'phone' => 'required|min:5|max:15',
            'password' => 'required|min:5|',
            'confirmPassword' => 'required|same:password',

        ]);
        if (!$validator->fails()) {
            $admin = new Admin();
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->phone = $request->phone;
            $admin->password = Hash::make($request->password);
            $isSaved = $admin->save();
            if ($isSaved) {
                return response()->json([
                    'message' => 'Admin created successfully',
                ], Response::HTTP_CREATED);
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    //----------------------------------------------------------------------------------------------------------------------
    public function login(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'email' => 'required|email|exists:admins,email',
                'password' => 'required|min:5|max:30',
            ],
            ['email.exists' => 'Email does not exists in Admin table']
        );
        if (!$validator->fails()) {
            $credintials = $request->only('email', 'password');
            if (Auth::guard('admin')->attempt($credintials)) {
                return response()->json([
                    'message' => 'Admin login successfully',
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
    //----------------------------------------------------------------------------------------------------------------------
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
