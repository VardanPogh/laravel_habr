<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function agent()
    {
        return view('admin', ['component' => '<agent-component></agent-component>']);
    }

    public function getAgent($id = null)
    {
        $user = User::with('role');
        if ($id) {
            $user = $user->find($id);
        } else {
            $user = $user->get();
        }

        return response()->json(['data' => $user]);
    }

    public function addEditAgent(Request $request)
    {
        if ($request->isMethod('get')) {

            return view('admin', ['component' => '<agent-add-edit-component></agent-add-edit-component>']);
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'id' => 'exists:users,id',
                'name' => 'required|string',
                'last_name' => 'required|string',
                'address' => 'required|string',
                'tel' => 'required|numeric',
                'business_name' => 'required|string',
                'name_of_store' => 'required|string',
                'province' => 'required|string',
                'vat_number' => 'required|string',
                'cap' => 'required|numeric',
                'common' => 'required|string',
                'email' => 'required|email|unique:users,email,'.($request->id ?? ''),
                'password' => 'required_without:id|min:6',
            ]);

            if($request->has('id')) {
                $user = User::find($request->id);
            } else {
                $user = new User();
            }

            if($request->has('password')){
                $user->password = bcrypt($request->password);

                $username = strtolower($request->name).'_'.strtolower($request->last_name);
                $user->username = $username;
            }
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->address = $request->address;
            $user->tel = $request->tel;
            $user->business_name = $request->business_name;
            $user->name_of_store = $request->name_of_store;
            $user->province = $request->province;
            $user->vat_number = $request->vat_number;
            $user->cap = $request->cap;
            $user->common = $request->common;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->status = 1;
            $user->save();


            return response()->json($user);
        }

        return response()->json(404);
    }

    public function destroyAgent(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->id);

        $user->delete();

        return response()->json(['message' => "successful"]);
    }

    public function changeRoleAgent(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'role_id' => 'required_without:status|exists:user_roles,id',
            'status' => 'required_without:role_id|in:0,1',
        ]);

        $user = User::find($request->id);
        if ($request->has('role_id')) {
            $user->role_id = $request->role_id;
        }
        if ($request->has('status')) {
            $user->status = $request->status;
        }

        $user->save();
        $user = User::with('role')->find($request->id);

        return response()->json(['data' => $user, 'message' => "successful"]);
    }
}
