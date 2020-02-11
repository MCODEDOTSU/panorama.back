<?php

namespace App\Http\Controllers\Constructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        $path = $request->fileres->store('storage/uploads','public');
        return response($path, 200);
    }
}
