<?php

namespace App\src\Services\Constructor\Entities;

use App\src\Repositories\Manager\ElementRepository;

class LinkField extends AbstractField implements FieldInterface
{
    public $type = 'integer';
    protected $elementRepository;

    public function __construct(ElementRepository $elementRepository)
    {
        $this->elementRepository = $elementRepository;
    }
    
    public function setDefaultValue()
    {
        return null;
    }
    
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function assignValue($value)
    {
        return $value['id'];
    }

    /**
     * @inheritDoc
     */
    public function extractValue($value)
    {
        return $this->elementRepository->getById($value);
    }
}
