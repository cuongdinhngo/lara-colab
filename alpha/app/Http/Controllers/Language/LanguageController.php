<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Cache;
use App\Http\Controllers\Language\LanguageService;
use App\Repositories\Language\LanguageInterface;

class LanguageController extends Controller
{
    protected $langRepo;

    public function __construct(LanguageInterface $langRepo)
    {
        $this->langRepo = $langRepo;        
    }

    public function test()
    {
        dd($this->langRepo->getAll());
    }

    public function generate(Request $request)
    {
        Artisan::call('generate:lang', [
            'locale' => $request->locale ?? null
        ]);
    }

    public function putCache()
    {
        $select = [
                'languages.locale as language_locale',
                'm.key',
                'm.content',
            ];
        $data = app(LanguageService::class)
                    ->getLanguageMessages([], $select)
                    ->mapToGroups(function ($item) {
                        return [$item['language_locale'] => [$item['key'] => $item['content']]];
                    })
                    ->map(function ($item, $key) {
                        return $item->collapse();
                    })
                    ->toArray();
        Cache::put('languages', $data);
        dump(Cache::get('languages'));
    }

    public function getCache(Request $request)
    {
        $key = $request->key;
        dump(trans_cache("languages.$key"));
    }

}
