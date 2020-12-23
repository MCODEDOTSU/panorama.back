<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\src\Models\Person;
use App\src\Models\History;
use Illuminate\Support\Facades\Log;

class NoteHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $persons = Person::get();
        foreach ($persons as $person) {
            if (empty($person->note)) {
                continue;
            }
            $notes = json_decode($person->note);

            if (gettype($notes) === 'object') {
                $history = $this->insert($notes);
                $person->history()->save($history);
                continue;
            }

            foreach ($notes as $note) {
                $history = $this->insert($note);
                $person->history()->save($history);
            }
        }
    }

    /**
     * Вставить запись в таблицу "История"
     *
     * @param $note
     * @return
     */
    private function insert($note)
    {
        $text = $note->value;
        if (!empty($text)) {
            $text = str_replace('<i>', '', $note->value);
            $text = str_replace('</i>', '', $text);
            $text = preg_replace("/\([\d\s\w\(\)\,\.\@]*\)/iu", '', $text);
            $text = trim($text);
            $text = str_replace('Запись сохранена', 'Запись изменена', $text);
        }
        print_r($text . "\n");
        return History::create([
            'text' => $text,
            'create_user_id' => 1,
            'type' => ($text === 'Запись создана' || $text === 'Запись изменена') ? 'system' : 'user',
            'created_at' => $note->dt / 1000,
            'updated_at' => $note->dt / 1000,
        ]);
    }
}
