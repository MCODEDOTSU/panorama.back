<?php

namespace App\src\Services\Manager;
use App\src\Repositories\Manager\LayerCompositionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

/**
 * Class LayerCompositionService
 * @package App\src\Services\Manager
 */
class LayerCompositionService
{
    protected $layerCompositionRepository;

    /**
     * LayerCompositionService constructor.
     * @param LayerCompositionRepository $layerCompositionRepository
     */
    public function __construct(LayerCompositionRepository $layerCompositionRepository)
    {
        $this->layerCompositionRepository = $layerCompositionRepository;
    }

    /**
     * Список состава слоя.
     * @param $layerId
     * @return \Illuminate\Support\Collection
     */
    public function getAll($layerId)
    {
        return $this->layerCompositionRepository->getAll($layerId);
    }

    /**
     * Обновить композицию.
     * @param int $id
     * @param Request $data
     * @return \App\src\Models\LayerComposition
     */
    public function update(int $id, Request $data)
    {
        return $this->layerCompositionRepository->update($id, $data);
    }

    /**
     * Создать композицию слоя.
     * @param Request $data
     * @return \App\src\Models\LayerComposition
     */
    public function create(Request $data)
    {
        return $this->layerCompositionRepository->create($data);
    }

    /**
     * Удалить композицию.
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        return $this->layerCompositionRepository->delete($id);
    }

    /**
     * Загрузить иконку
     * @param $file
     * @return mixed
     */
    public function uploadIcon($file)
    {
        $path = $file->hashName('images/compositions');
        list($width, $height) = getimagesize($file);
        $image = Image::make($file);

        if($width > 48 || $height > 48) {
            $image->fit(48, 48, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        Storage::put("public/$path", (string)$image->encode());
        list($width, $height) = getimagesize("storage/$path");

        return [
            'filename' => "storage/$path",
            'width' => $width,
            'height' => $height
        ];
    }

}
