<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;

class LanguageController extends Controller
{
    public function generate(Request $request)
    {
        Artisan::call('generate:lang', [
            'locale' => $request->locale ?? null
        ]);
    }
}
