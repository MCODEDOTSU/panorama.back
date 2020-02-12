<?php

namespace App\Http\Controllers\Constructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        $path = $request->fileres->store('storage/uploads','public');
        return response($path, 200);
    }

    public function downloadFile(Request $request)
    {
        $path = Storage::disk('public')->path($request->filepath['path']);
        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($path, $request->filepath['name'], $headers);
    }
}
