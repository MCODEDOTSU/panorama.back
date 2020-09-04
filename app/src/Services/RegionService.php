<?php

namespace App\src\Services;

use App\src\Repositories\RegionRepository;
use Illuminate\Support\Collection;

/**
 * Class RegionService
 * @package App\src\Services
 */
class RegionService
{
    protected $regionRepository;

    /**
     * RegionService constructor.
     * @param RegionRepository $regionRepository
     */
    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    /**
     * Получить все регионы.
     * @return Collection
     */
    public function getAll()
    {
        return $this->regionRepository->getAll();
    }

}
