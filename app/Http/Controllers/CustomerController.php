<?php

namespace App\Http\Controllers;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customers.index');
    }

    public function create()
    {
        return view('customers.create');
    }
}
