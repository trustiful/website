$(document).ready(function() {
    $("#disconnect").click(function(e) {
        e.preventDefault();
        $.get(
            '../handlers/disconnect.php',
            {
            },
            function (data) {
                if(data.disconnected){
                    window.location.href = './login.html';
                }
            },
            'json'
        );
    });
});