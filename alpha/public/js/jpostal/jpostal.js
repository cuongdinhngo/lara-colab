JPortal = function() {

    let url = '/js/jpostal/data/' ;
    let cache = {};
    let prefectures, zipData;
    let prefCode, prefecture, city, area, street;

    function capture(search, response) {

        let zip = '';
        let zipFile = '';

        /**
         * Verify & get Zip value
         */
        if (search.includes('#')) {
            let id = search.slice(1);
            zip = document.getElementById(id).value;
        }
        if (search.includes('.')) {
            let className = search.slice(1);
            let elements = document.getElementsByClassName(className);
            if (elements.length > 0) {
                zip = elements[0].value;
            } else {
                console.log('[JPostal] Not Found Element');
                return;
            }
        }

        /**
         * Check Zip validation
         */
        if (zip.length < 3) {
            console.log('[JPostal] Invalid Code');
            return;
        }

        if (zip.includes('-')) {
            zipFile = zip.split('-')[0];
            zip = zip.replace('-', '');
        } else {
            zipFile = zip.slice(0, 3);
        }

        if (isNaN(parseInt(zipFile)) || parseInt(zipFile) < 1 || parseInt(zipFile) > 999) {
            console.log('[JPostal] Invalid Code');
            return;
        }

        /**
         * Get result
         */
        if (cache[zipFile]) {
            zipData = cache[zipFile][zip];
            combineResponse(response);
        } else {
            fetch(url + "zip-" + zipFile + ".json")
            .then(response => response.json())
            .then(data => {
                zipData = data[zip];
                if (zipData === undefined || ! zipData[0]) {
                    console.log('[JPostal] Invalid Code');
                    return;
                }
                if (!cache[zipFile]) {
                    cache[zipFile] = data;
                }
                combineResponse(response);
            });
        }
    }

    /**
     * Combine response
     * 
     * @param {*} response 
     * @returns 
     */
    function combineResponse(response)
    {
        if (zipData === undefined || ! zipData[0]) {
            console.log('[JPostal] Invalid Code');
            return;
        }
        if (/^\d+$/.test(zipData[0])) {
            prefCode = zipData[0];
            prefecture = prefectures[prefCode];
            zipData[0] = prefecture;
        }

        /**
         * Response is Array
         */
        if (typeof response === 'object' && response.length == 1) {
            let result = zipData.filter(item => item.length > 0).join(', ');
            innerHtmlTag(response[0], result);
        }
        if (typeof response === 'object' && response.length > 1) {
            response.forEach((item, index) => {
                innerHtmlTag(item, zipData[index]);
            });
        }

        /**
         * Response is Function
         */
        if (typeof response === 'function') {
            const keys = ['prefecture', 'city', 'area', 'street'];
            const rs = {};
            keys.map((key, index) => rs[key] = zipData[index]);
            response(rs);
        }
    }

    /**
     * Assign value into html tag
     *
     * @param {*} tag 
     * @param {*} tagValue 
     */
    function innerHtmlTag(tag, tagValue)
    {
        if (tag.includes('#')) {
            let id = tag.slice(1);
            document.getElementById(id).value = tagValue;
        }
        if (tag.includes('.')) {
            let className = tag.slice(1);
            let elements = document.getElementsByClassName(className);
            if (elements.length > 0) {
                elements[0].value = tagValue;
            }
        }
    }

    /**
     * Get prefectures data
     */
    function getPrefectures()
    {
        fetch(url + "prefectures.json")
        .then(response => response.json())
        .then(data => prefectures = data);
    }

    return {
        init: function () {
            getPrefectures();
        },
        capture: capture,
        prefectures: prefectures,
    }
}();