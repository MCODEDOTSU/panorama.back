<?php

namespace App\src\Repositories;

use App\src\Models\Region;
use Illuminate\Support\Collection;

class RegionRepository
{
    protected $region;

    /**
     * RegionRepository constructor.
     * @param $region
     */
    public function __construct(Region $region)
    {
        $this->region = $region;
    }

    /**
     * Все регионы.
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->region->get();
    }

}
