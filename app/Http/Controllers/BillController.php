<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillController extends Controller
{
    public function handleUpload(Request $request) {
        // validate upload 
 

        if ($request->hasFile('file')) { 
            $fileName   = time() . '.json';
             
            $path = $request->file('file')->storeAs(
                'files', $fileName
            );
        }
    }
}
