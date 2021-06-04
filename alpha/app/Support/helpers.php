<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

if (!function_exists('trans_cache')) {
    /**
     * Get translated value in cache
     * @param  string $params
     * @return mixed
     */
    function trans_cache($params = null)
    {
        if (is_null($params)) {
            return;
        }

        $keys = explode('.', $params);
        $cacheKey = array_shift($keys);

        if (is_null($cacheData = Cache::get($cacheKey))) {
        	return $cacheData;
        }

        $currentLocale = App::getLocale();
        $data = $cacheData[$currentLocale];
        foreach ($keys as $key) {
            $data = $data[$key];
        }
        return $data;
    }
}

if (!function_exists('get_current_locale')) {
	/**
	 * Get current locale
	 * 
	 * @return string
	 */
	function get_current_locale()
	{
		$request = request();
		if (false !== strpos($request->path(), 'api') || $request->wantsJson()) {
			$locale = $request->header('X-LOCALE');
		} else {
			$locale = $request->get('locale') ?? session()->get('locale');
		}
		return $locale ?? App::getLocale();
	}
}
