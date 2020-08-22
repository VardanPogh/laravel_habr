<?php

namespace App\Http\Controllers;

use App\ManagerOptions;
use Illuminate\Http\Request;

class ManagerOptionsController extends Controller
{
    public function index()
    {
        return view('admin', ['component' => '<managers-component></managers-component>']);
    }

    public function getManagerOptions()
    {
        $manager = ManagerOptions::all();

        return response()->json(['data' => $manager]);
    }

    public function addEditManagerOptions(Request $request)
    {
        $request->validate([
            'id' => 'exists:manager_options,id',
            'name' => 'required|string',
        ]);

        $manager = new ManagerOptions();

        if($request->has('id')) {
            $manager = ManagerOptions::find($request->id);
        }

        $manager->name = $request->name;
        $manager->save();

        return response()->json( $manager );
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:manager_options,id'
        ]);

        $manager = ManagerOptions::find($request->id);

        $manager->delete();

        return response()->json(['message' => "successful"]);
    }
}
