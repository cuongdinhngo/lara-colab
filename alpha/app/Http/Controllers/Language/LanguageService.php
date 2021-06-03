<?php

namespace App\Http\Controllers\Language;

use App\Models\Language;

class LanguageService
{
    public function getLanguageMessages(array $where = [],array $select = ['*'])
    {
        return Language::select($select)
                ->join('messages AS m', 'languages.id', '=', 'm.language_id')
                ->where($where)
                ->get();
    }
}
