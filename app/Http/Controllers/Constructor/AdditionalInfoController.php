<?php

namespace App\Http\Controllers\Constructor;


use App\Http\Controllers\Controller;
use App\src\Services\Constructor\AdditionalInfoService;

class AdditionalInfoController extends Controller
{
    private $additionalInfoService;

    public function __construct(AdditionalInfoService $additionalInfoService)
    {
        $this->additionalInfoService = $additionalInfoService;
    }

    public function getData(int $elementId, int $tableIdentifier)
    {
        $additionalInfo = $this->additionalInfoService->getData($elementId, $tableIdentifier);
        return response($additionalInfo, 200);
    }
}
