<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Validator;

class UsersapiController extends Controller
{


    public function showapi($id = null)
    {
        if ($id == '') {
            $user = User::get();
            return response()->json(['user' => $user], 200);
        } else {
            $user = User::find($id);
            return response()->json(['user' => $user], 200);
        }
    }

    //all user profile

    public function alluser($id = null)
    {
        if ($id == '') {
            $user = User::get();
            return response()->json(['user' => $user]);
        } else {
            $user = User::find($id);
            return response()->json(['user' => $user]);
        }
    }



    // all user list 
    public function userlist($id = null)
    {
        if ($id == '') {
            $userlist = User::get();
            return  response()->json(['userlist' => $userlist], 200);
        } else {
            $userlist = User::find($id);
            return  response()->json(['userlist' => $userlist], 200);
        }
    }



    //add post user api
    public function add_user(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            //=========validation start=========

            $ruls = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ];
            $custom_message = [
                'name.required' => 'Name is Required',
                'email.required' => 'Email is Required',
                'email.email' => 'Email Must Be Valid',
                'password.required' => 'Password is Required',
            ];

            $validators = Validator::make($data, $ruls, $custom_message);
            if ($validators->fails()) {

                return response()->json($validators->errors(), 422);
            }
            //========validation end=============


            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();

            $message = 'User Added Successfully!';
            return response()->json(['message' => $message], 201);
        }
    }


    //update user post user api
    public function update_user(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $data = $request->all();

            //=========validation start=========

            $ruls = [
                'name' => 'required',
                'password' => 'required',
            ];
            $custom_message = [
                'name.required' => 'Name is Required',
                'password.required' => 'Password is Required',
            ];

            $validators = Validator::make($data, $ruls, $custom_message);
            if ($validators->fails()) {

                return response()->json($validators->errors(), 422);
            }
            //========validation end=============


            $user = User::findorfail($id);
            $user->name = $data['name'];
            $user->password = bcrypt($data['password']);
            $user->save();

            $message = 'User update Successfully!';
            return response()->json(['message' => $message], 202);
        }
    }


    //sinlge update user post user api
    public function update_user_single(Request $request, $id)
    {
        if ($request->isMethod('patch')) {
            $data = $request->all();

            //=========validation start=========

            $ruls = [
                'name' => 'required',

            ];
            $custom_message = [
                'name.required' => 'Name is Required',
            ];

            $validators = Validator::make($data, $ruls, $custom_message);
            if ($validators->fails()) {

                return response()->json($validators->errors(), 422);
            }
            //========validation end=============


            $user = User::findorfail($id);
            $user->name = $data['name'];
            $user->save();

            $message = 'User update Successfully!';
            return response()->json(['message' => $message], 202);
        }
    }


    //single delete user api
    public function delete_user_single($id = null)
    {
        User::findorfail($id)->delete();
        $message = 'User delete Successfully!';
        return response()->json(['message' => $message], 200);
    }

    //single delete user apiwith json
    public function delete_user_singlejson(Request $request)
    {
        if ($request->isMethod('delete')) {
            $data = $request->all();
            User::where('id', $data['id'])->delete();
            $message = 'User delete Successfully!';
            return response()->json(['message' => $message], 200);
        }
    }



    //multiple delete user api
    public function delete_user_multi($ids)
    {
        $ids = explode(',', $ids);
        User::whereIn('id', $ids)->delete();
        $message = 'User delete Successfully!';
        return response()->json(['message' => $message], 200);
    }

    //multiple delete user apiwith json
    public function delete_user_multijson(Request $request)
    {
        if ($request->isMethod('delete')) {
            $data = $request->all();
            User::whereIn('id', $data['ids'])->delete();
            $message = 'User delete Successfully!';
            return response()->json(['message' => $message], 200);
        }
    }














    //add multiple user api
    public function add_usermultiple(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            //=========validation start=========

            $ruls = [
                'users.*.name' => 'required',
                'users.*.email' => 'required|email|unique:users',
                'users.*.password' => 'required',
            ];
            $custom_message = [
                'users.*.name.required' => 'Name is Required',
                'users.*.email.required' => 'Email is Required',
                'users.*.email.email' => 'Email Must Be Valid',
                'users.*.password.required' => 'Password is Required',
            ];

            $validators = Validator::make($data, $ruls, $custom_message);
            if ($validators->fails()) {

                return response()->json($validators->errors(), 422);
            }
            //========validation end=============


            foreach ($data['users'] as $adusers) {

                $user = new User();
                $user->name = $adusers['name'];
                $user->email = $adusers['email'];
                $user->password = bcrypt($adusers['password']);
                $user->save();

                $message = 'User Added Successfully!';
            }
            return response()->json(['message' => $message], 201);
        }
    }
}
