<?php

namespace App\src\Repositories;

use App\src\Models\History;
use Illuminate\Support\Collection;

/**
 * Class HistoryRepository
 * @package App\src\Repositories
 */
class HistoryRepository
{

    /**
     * Создать
     *
     * @param $data
     * @return History
     */
    public static function create($data): History
    {
        return History::create($data);
    }

    /**
     * Изменить
     *
     * @param int $id
     * @param $data
     * @return mixed
     */
    public static function update(int $id, $data)
    {
        $history = History::find($id);
        if ($history->type === 'system') {
            return false;
        }
        $history->text = $data->text;
        $history->update_user_id = $data->update_user_id;
        $history->save();
        return History::find($id);
    }

    /**
     * Удалить
     *
     * @param $id
     * @return mixed
     */
    public static function delete(int $id)
    {
        $history = History::find($id);
        $history->delete();
    }

}
