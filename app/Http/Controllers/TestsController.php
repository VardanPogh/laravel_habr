<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    public function index()
    {

      // dd($transaction->adminTransactionUsers()->get());
     //  dd($transaction->user()->where('admin_id', '!=', null)->get());
    }
}
