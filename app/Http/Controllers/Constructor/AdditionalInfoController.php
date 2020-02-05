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

    /**
     * Получить данные дополнительных полей для слоя и элемента
     * @param int $layerId
     * @param int $elementId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getData(int $layerId, int $elementId)
    {
        $additionalInfo = $this->additionalInfoService->getData($layerId, $elementId);
        return response($additionalInfo, 200);
    }
}
