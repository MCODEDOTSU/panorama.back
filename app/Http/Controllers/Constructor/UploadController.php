<?php

namespace App\Http\Controllers\Constructor;

use App\Http\Controllers\Controller;
use App\src\Services\Constructor\AdditionalInfoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    private $additionalInfoService;

    public function __construct(AdditionalInfoService $additionalInfoService)
    {
        $this->additionalInfoService = $additionalInfoService;
    }

    public function uploadFile(Request $request)
    {
        // TODO: Дополнительно сохранить информацию в БД
        $path = $request->fileres->store('storage/uploads', 'public');
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

    /**
     * @param Request $request
     * @return mixed
     * request params:
     * filepath - path of the file
     * tableIdentifier - value of table to delete
     * columnName - column to make it null
     * elementId - for where clause while deleting
     */
    public function deleteFile(Request $request)
    {
        try {
            Storage::disk('public')->delete($request->filepath);
            $this->additionalInfoService->cleanDocField(
                $request->tableIdentifier,
                $request->columnName,
                $request->elementId);
            return response('File has been deleted', 200);
        } catch (\Exception $e) {
            return response('Unable to delete file', 400);
        }
    }
}
