<?php

namespace App\Http\Controllers;

use App\FixedServices;
use App\Services;
use App\UllTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ServicesController extends Controller
{
    public function index()
    {

        return view('admin', ['component' => '<services-component></services-component>']);
    }

    public function getServices($id = null)
    {
        if ($id) {
            $services = Services::find($id);

        } else {
           // $services = Services::where('with_protocol', 1)->get();
            $services = Services::get();
        }
        return response()->json(['data' => $services]);
    }


    public function addEditServices(Request $request)
    {
       
        if ($request->isMethod('get')) {

            return view('admin', ['component' => '<services-add-edit-component></services-add-edit-component>']);
        }


       
        if ($request->isMethod('post')) {
            $request->validate([
                'id' => 'exists:services,id',
                'title' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'agent_percent' => 'required|numeric',
                'admin_percent' => 'required|numeric',
                'status' => 'in:0,1',
                'options' => 'in:0,1,2',
                'category_id' => 'required|exists:categories,id',
                'image' => 'required_without:id',
                'with_protocol' => 'required',
                'durata' => 'required',
                'form_type' => 'required|int',
                'course' => '',
            ]);




            $services = new Services();

            if($request->has('id')) {
                $services = Services::find($request->id);
            }
            if($request->hasFile('image')){
                if($request->has('image_old') && file_exists('/public'.$request->image_old)) {
                    unlink('/public'.$request->image_old);
                }
                $file = $request->file('image');
                $nameOri = join('_', explode(' ', $file->getClientOriginalName()));
                $fileName = '/image/services/'.time().'_categories_'.$nameOri;
                $file->move(public_path('image/services'), $fileName);
                // if(file_exists(public_path(substr($services->image, 7,strlen ($services->image))))) {
                //     File::delete(public_path(substr($services->image, 7,strlen ( $services->image))));
                // }
                if(file_exists(public_path($services->image))) {
                    File::delete(public_path($services->image));
                }
                $services->image = $fileName;
            }
            if (!$request->has('status')) {
                $services->status = 1;
            } else {
                $services->status = $request->status;
            }

            if (!$request->has('options')) {
                $services->options = 1;
            } else {
                $services->options = $request->options;
            }
        
            if (!$request->has('course') && !isset($request->course) ) {
                $services->course = 0;
            } else {
                $services->course = $request->course;
            }
    
            $services->title = $request->title;
            $services->description = $request->description;
            $services->price = $request->price;
            $services->agent_percent = $request->agent_percent;
            $services->admin_percent = $request->admin_percent;
            $services->category_id = $request->category_id;
            $services->with_protocol = $request->with_protocol;
            $services->iva = $request->iva;
            $services->durata = $request->durata;
            $services->form_type = $request->form_type;


            $services->save();

            return response()->json($services);
        }

        return response()->json(404);
    }

    public function changeStatusOptionsServices(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:services,id',
            'status' => 'in:0,1',
            'options' => 'in:0,1,2'
        ]);

        $services = Services::find($request->id);
        if($request->has('status')) {
            $services->status = $request->status;
        }
        if($request->has('options')) {
            $services->options = $request->options;
        }

        $services->save();

        return response()->json(['data' => $services,'message' => "successful"]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:services,id'
        ]);

        $services = Services::find($request->id);

        $services->delete();

        return response()->json(['message' => "successful"]);
    }
}
