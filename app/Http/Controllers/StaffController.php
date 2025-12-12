<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\DataInduk;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $dataInduk = DataInduk::orderBy('id', 'asc')->get();
        return view('pages.system.staff', compact('dataInduk'));
    }

    public function store(Request $request)
    {
        
    }

    public function update(Request $request, $id)
    {
       
    }

    public function destroy($id)
    {
        
    }
}
