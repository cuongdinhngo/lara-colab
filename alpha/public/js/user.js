User = function () {
    var name = 'Cuong';
    function abc(){
        console.log('init ...........');
    }
    function change(){
        console.log('change ...........');
    }
    function verify(){
        console.log('verify ...........');
    }
    function rememberMe(){
        $(document).on('click', '#remember', function () {
            console.log('remember me ....');
        });
    }
    return {
        init: function() {
            abc();
            change();
            verify();
        },
        rememberMe: rememberMe,
        name: name,
    }
}();
