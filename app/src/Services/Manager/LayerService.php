<?php

namespace App\src\Services\Manager;
use App\src\Models\Layer;
use App\src\Repositories\Manager\LayerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Image;

/**
 * Class LayerService
 * @package App\src\Services\Manager
 */
class LayerService
{
    protected $layerRepository;

    /**
     * LayerService constructor.
     * @param LayerRepository $layerRepository
     */
    public function __construct(LayerRepository $layerRepository)
    {
        $this->layerRepository = $layerRepository;
    }

    /**
     * Получить все слои.
     * @return Collection
     */
    public function getAll()
    {
        return $this->layerRepository->getAll();
    }

    /**
     * Получить все слои для контрагента.
     * @return Collection
     */
    public function getAllToContractor()
    {
        $user = Auth::user();

        // Получить слои доступные через родительского контрагента
        // Получить родительского контрагента
        $userContractor = $user->contractor()->first();

        // Получить слои доступные контрагенту напрямую
        return $this->layerRepository->getAllToContractor($user->contractor_id, $userContractor->parent_id);
    }

    /**
     * Получить все слои указанного типа
     * @param string $type
     * @return \App\src\Repositories\Manager\Response|\App\src\Repositories\Manager\ResponseFactory
     */
    public function getByType(string $type)
    {
        return $this->layerRepository->getByType($type);
    }

    /**
     * Получить слой по ИД
     * @param int $id
     * @return Layer
     */
    public function getById(int $id): Layer
    {
        return $this->layerRepository->getById($id);
    }

    /**
     * Изменить слой.
     * @param int $id
     * @param Request $data
     * @return Layer
     */
    public function update(int $id, Request $data)
    {
        return $this->layerRepository->update($id, $data);
    }

    /**
     * Создать слой.
     * @param Request $data
     * @return Layer
     */
    public function create(Request $data)
    {
        return $this->layerRepository->create($data);
    }

    /**
     * Удалить слой.
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        return $this->layerRepository->delete($id);
    }

    /**
     * Загрузить иконку
     * @param $file
     * @return mixed
     */
    public function uploadIcon($file)
    {
        $path = $file->hashName('images/layers');
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
