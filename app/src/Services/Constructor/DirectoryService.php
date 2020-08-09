<?php


namespace App\src\Services\Constructor;


use App\src\Repositories\Constructor\DirectoryRepository;
use App\src\Services\AbstractService;
use Illuminate\Support\Facades\DB;

class DirectoryService extends AbstractService
{
    public function __construct(DirectoryRepository $directoryRepository)
    {
        $this->repository = $directoryRepository;
    }

    /**
     * @param $entityName
     * Так как набор полей разный, для:
     * entityName = contractors => выбирается поле 'name'
     * entityName = persons => выбираются поля 'firstname' + 'lastname' + 'middlename'
     * @return
     */
    public function getEntities($entityName)
    {
        $query = DB::table($entityName);
        switch ($entityName) {
            case 'persons':
                $query->select(DB::raw("CONCAT(lastname, ' ',firstname, ' ',middlename) AS value"), 'id');
                break;
            case 'contractors':
                $query->select('name as value', 'id');
                break;
        }

        return $query->get();
    }
}
