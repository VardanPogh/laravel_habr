<?php

namespace App\Http\Controllers;

use App\Categories;
use App\GeneralCategories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        return view('admin', ['component' => '<categories-component></categories-component>']);
    }

    public function getCategories($id = null)
    {
        $categories = Categories::with('services');
        if ($id) {
            $categories = $categories->find($id);
        } else {
            $categories = $categories->get();
        }

        return response()->json(['data' => $categories]);
    }

    public function addEditCategories(Request $request)
    {
        if ($request->isMethod('get')) {

            return view('admin', ['component' => '<categories-add-edit-component></categories-add-edit-component>']);
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'id' => 'exists:categories,id',
                'name' => 'required|string',
                'desc' => 'required|string',
                'general_category_id' => 'required|exists:general_categories,id',
            ]);

            $categories = new Categories();

            if($request->has('id')) {
                $categories = Categories::find($request->id);
            }
            if($request->hasFile('image')){
                if($request->has('image_old') && file_exists(public_path($request->image_old))) {
                    unlink(public_path($request->image_old));
                }
                $file = $request->file('image');
                $nameOri = join('_', explode(' ', $file->getClientOriginalName()));
                $fileName = time().'_categories_'.$nameOri;
                $file->move(public_path('image/categories'), $fileName);
                $categories->image = '/image/categories/'. $fileName;
            }

            $categories->name = $request->name;
            $categories->desc = $request->desc;
            $categories->general_category_id = $request->general_category_id;
            $categories->save();

            return response()->json( $categories );
        }

        return response()->json(404);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:categories,id'
        ]);

        $categories = Categories::with('services')->find($request->id);

        if (count($categories->services) > 0) {
            return response()->json(['message' => "Deletion canceled. Exist reletion."]);
        }

        $categories->delete();

        return response()->json(['message' => "successful"]);
    }

    public function general()
    {
        return view('admin', ['component' => '<general-categories-component></general-categories-component>']);
    }

    public function getGeneralCategories()
    {
        $categories = GeneralCategories::all();

        return response()->json(['data' => $categories]);
    }

    public function addEditGeneralCategories(Request $request)
    {
        $request->validate([
//            'id' => 'exists:general_categories,id',
            'name' => 'required|string',
        ]);

        $generalCategories = new GeneralCategories();

        if($request->has('id')) {
            $generalCategories = GeneralCategories::find($request->id);
        }

        $generalCategories->name = $request->name;
        $generalCategories->save();

        return response()->json( $generalCategories );
    }

    public function destroyGeneral(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:general_categories,id'
        ]);

        $categories = GeneralCategories::find($request->id);

        $categories->delete();

        return response()->json(['message' => "successful"]);
    }
}
