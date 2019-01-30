<?php

namespace App\Http\Controllers\System\XML;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemsController extends Controller
{
    public function index()
    {
        return view('dash.modules.xmlitems');
    }

    public function sendXML(Request $request){
        
        

    }
}
