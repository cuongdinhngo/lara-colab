<?php

namespace App\Repositories\Language;

use App\Repositories\BaseRepository;
use App\Repositories\Language\LanguageInterface;

class LanguageRepository extends BaseRepository implements LanguageInterface
{
    public function getModel()
    {
        return \App\Models\Language::class;
    }
}
