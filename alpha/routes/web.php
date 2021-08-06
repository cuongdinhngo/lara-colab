<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/lang/{locale}', 'Language\LanguageController@generate');

Route::put('/put-cache', 'Language\LanguageController@putCache');

Route::group(['middleware' => ['locale']], function () {
    Route::get('/get-cache/{key}', 'Language\LanguageController@getCache');
});

Route::get("/notify", function(){
    return App\Models\User::find(1)->notify(new App\Authentication\SendOtp('twilio', 4, 10));
});

Route::get("/check-otp/{otp}", function(){
    dump(request()->otp);
    // return auth()->user->checkOtp(request()->otp);
    return App\Models\User::find(1)->checkOtp(request()->otp);
});

Route::get("/check-otp/{otp}", function(){
    dump(request()->otp);
    return App\Models\User::authByOtp(request()->otp, '84905279285');
});

Route::get("/bot", function () {
    // detect user-agents of  crawlers and block via .htaccess
    dd($_SERVER);
});

Route::get('/test', 'Language\LanguageController@test');

// Route::get('/pref', function(Filesystem $file) {
//     $prefPath = database_path('data/prefecture.json');
//     $pref = $file->get($prefPath);
//     $arr = json_decode($pref, true)['prefectures'];
//     $rs = [];
//     foreach($arr as $item) {
//         $rs[$item['code']] = $item['name'];
//     }
//     $path = config_path('prefectures.php');
//     $file->put(
//         $path,
//         '<?php '.PHP_EOL.''.PHP_EOL.'return '.var_export($rs, true).';'.PHP_EOL
//     );
// });

// Route::get('/city', function(Filesystem $file) {
//     $citiesPath = database_path('data/citycode3.json');
//     $cities = $file->get($citiesPath);
//     $arr = json_decode($cities, true);
//     $rs = [];
//     foreach($arr as $city => $item) {
//         $path = config_path("city-{$city}.php");
//         $file->put(
//             $path,
//             '<?php '.PHP_EOL.''.PHP_EOL.'return '.var_export($item['data'], true).';'.PHP_EOL
//         );
//     }
// });

// Route::get('/zip', function(Filesystem $file) {
//     $files = glob(app_path().'/../database/data/zipdata/zip-*.js');
//     foreach($files as $item){
//         $zip = $file->get($item);
//         $tmp = substr($zip, 8);
//         $zip = substr($tmp, 0, -6);
//         $arr = json_decode($zip, JSON_FORCE_OBJECT);
//         $name =basename($item, ".js");
//         $path = config_path("jpostal/{$name}.php");
//         $file->put(
//             $path,
//             '<?php '.PHP_EOL.''.PHP_EOL.'return '.var_export($arr, true).';'.PHP_EOL
//         );
//     }

// });

// Route::get('/json', function(Filesystem $file) {
//     $files = glob(config_path()."/jpostal/*.php");
//     foreach($files as $item){
//         $name = basename($item, ".php");
//         $content = config("jpostal.{$name}");
//         $json = json_encode($content, JSON_UNESCAPED_UNICODE);
        
//         $path = public_path("js/jpostal/{$name}.json");
//         $file->put(
//             $path,
//             $json
//         );
//     }

// });

Route::get('/jpostal', function(){
    return view('user.jpostal');
});

Route::get('/csv', function(){
    return view('user.csv');
})->name('csv-form');

Route::post('/csv', 'User\UserController@postCSV')->name('csv-post');

Route::get('/download-csv', 'User\UserController@downloadCSV')->name('csv-download');

Route::group(['namespace' => 'User', 'prefix' => 'users'], function(){
    Route::get('/', 'UserController@index');
});