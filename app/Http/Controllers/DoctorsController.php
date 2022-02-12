<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use Symfony\Component\HttpFoundation\Response;

class DoctorsController extends Controller
{
    public function create(Request $request){
        $validator=Validator($request->all(),[
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255',
            'password'=>'required|string|min:5|',
            'hospital'=>'required|string|max:255',

        ]);

        if(!$validator->fails()){
            $doctor = new Doctor();
            $doctor->name  =$request->name;
            $doctor->email =$request->email;
            $doctor->hospital =$request->hospital;
            $doctor->password = Hash::make($request->password);
            $isSaved= $doctor->save();
            if($isSaved){
                return response()->json([
                    'message'=>'Doctor created successfully',
                ],Response::HTTP_CREATED);
            }else{
                return response()->json([
                    'message'=>'Doctor not created',
                ],Response::HTTP_BAD_REQUEST);
            }
        }else{
            return response()->json([
                'message'=>$validator->getMessageBag()->first(),
            ],Response::HTTP_BAD_REQUEST);
        }

    }

    public function login(Request $request){

        $validator=Validator($request->all(),[
            'email'=>'required|string|email|max:255',
            'password'=>'required|string|min:5|',
        ]);

        if(!$validator->fails()){
            $credintials = $request->only('email', 'password');
            if (Auth::guard('doctor')->attempt($credintials)) {
                return response()->json([
                    'message' => 'Doctor login successfully',
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'Invalid email or password',
                ], Response::HTTP_BAD_REQUEST);
            }
        }else{
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }

    }


    public function logout(){
        Auth::guard('doctor')->logout();
        return redirect('/');
    }






}
