<?php

namespace App\Http\Controllers;

use App\Categories;
use App\FixedServices;
use App\GeneralCategories;
use App\ManagerOptions;
use App\Services;
use App\ServicesReload;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index($id = null, $category_id = null)
    {

        $datas['services'] = [];
        $datas['categories'] = [];
        $datas['fixed_services']= [];
        $datas['general'] = GeneralCategories::all();
        if($id) {
            $datas['categories'] = Categories::where('general_category_id', $id)->get();
            $datas['general_id'] = $id;
        }
        if($category_id) {
            $datas['services'] = Services::where('category_id', $category_id)->where('status', 1)->get();
            $datas['category_id'] = $category_id;
        }
        $menegers = ManagerOptions::all();

        return view('home', collect(['datas'=>$datas, 'menegers' => $menegers]));
    }
}
