<?php

namespace App\Http\Controllers\Constructor;

use App\Http\Controllers\Controller;
use App\src\Services\Constructor\AdditionalInfoService;
use App\src\Services\Constructor\ConstructorMetadataService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class UploadController extends Controller
{
    private $additionalInfoService;
    private $constructorMetadataService;

    public function __construct(
        AdditionalInfoService $additionalInfoService,
        ConstructorMetadataService $constructorMetadataService
    )
    {
        $this->additionalInfoService = $additionalInfoService;
        $this->constructorMetadataService = $constructorMetadataService;
    }

    /**
     * Загрузка
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function uploadFiles(Request $request)
    {
        try {
            return response($this->additionalInfoService->uploadFiles($request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

//    /**
//     * @param Request $request
//     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
//     * request:
//     * fileres: blob file,
//     * identifier: ConstructorMetadata->id
//     * elementId: ID of specified element in layer
//     */
//    public function uploadFile(Request $request)
//    {
//        /** @var ConstructorMetadata $constructorMetadata */
//        $constructorMetadata = $this->constructorMetadataService->getById($request->identifier);
//
//        if (!$constructorMetadata->tech_title == 'doc_type') {
//            return response('This is not doc_field', 400);
//        }
//
//        $uploadedFileExtension = $request->fileres->extension();
//        if (!in_array($uploadedFileExtension, $constructorMetadata->enums)) {
//            return response('Неверный формат данных', 400);
//        }
//
//        // Check only if additional data is not new
//        if ($request->elementId != 0) {
//            $attachedFiles = DB::table($constructorMetadata->table_identifier)
//                ->select($constructorMetadata->tech_title)
//                ->where('element_id', $request->elementId)
//                ->first();
//
//            // If there is no attached files yet
//            if (!$attachedFiles) {
//                $path = $request->fileres->store('storage/uploads', 'public');
//                return response($path, 200);
//            }
//
//            $techTitle = $constructorMetadata->tech_title;
//            $metadata = $attachedFiles->$techTitle;
//            $countAttachedFiles = count(json_decode($metadata));
//
//            if ($countAttachedFiles >= $constructorMetadata->options->quantity) {
//                return response('Limit of attached files have been exceeded', 400);
//            }
//
//            $path = $request->fileres->store('storage/uploads', 'public');
//            return response($path, 200);
//        }
//
//        $path = $request->fileres->store('storage/uploads', 'public');
//        return response($path, 200);
//    }

//    public function downloadFile(Request $request)
//    {
//        $path = Storage::disk('public')->path($request->filepath['path']);
//        $headers = array(
//            'Content-Type: application/pdf',
//        );
//
//        return Response::download($path, $request->filepath['name'], $headers);
//    }

//    /**
//     * @param Request $request
//     * @return mixed
//     * request params:
//     * filepath - path of the file
//     * tableIdentifier - value of table to delete
//     * columnName - column to make it null
//     * elementId - for where clause while deleting
//     * index - index of deletable information concerning file
//     */
//    public function deleteFile(Request $request)
//    {
//        try {
//            Storage::disk('public')->delete($request->filepath);
//            $filesInfo = $this->additionalInfoService->cleanDocField(
//                $request->tableIdentifier,
//                $request->columnName,
//                $request->elementId,
//                $request->index);
//            return response($filesInfo, 200);
//        } catch (\Exception $e) {
//            return response($e->getMessage(), 400);
//        }
//    }
}
