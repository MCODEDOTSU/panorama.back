<?php

namespace App\src\Services\Info;


use App\src\Repositories\Info\AddressRepository;
use App\src\Repositories\Info\ElementRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ElementService
{
    protected $elementRepository;
    protected $addressRepository;

    /**
     * ElementService constructor.
     * @param ElementRepository $elementRepository
     * @param AddressRepository $addressRepository
     */
    public function __construct(ElementRepository $elementRepository, AddressRepository $addressRepository)
    {
        $this->elementRepository = $elementRepository;
        $this->addressRepository = $addressRepository;
    }

    public function update(Request $data)
    {
        $element = $this->elementRepository->getById($data->id);

        $element = $this->elementRepository->update($element, $data);

        return $element;
    }

    public function create(Request $data)
    {
        $data->visibility = 'hidden';
        $element = $this->elementRepository->create($data);

        return $element;
    }

    public function delete($id)
    {
        return $this->elementRepository->delete($id);
    }

}
