var a = function () {
    var url = window.location.protocol + '//' + window.location.hostname;

    $(document).ready(function () {
        $.post(
            '../ajax/certificate.php',
            {
                url: url
            },
            function (data) {
                if (data.html) {
                    $('head').append('<link href="https://fonts.googleapis.com/css?family=Lato:400,700,700i,900,900i" rel="stylesheet">');
                    $('head').append('<link rel="stylesheet" href="../views/css/trustiful.css" type="text/css" />');
                    $('head').append('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">');
                    $('head').append('<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>');
                    $('head').append('<style>body{background-color: grey;}</style>');
                    $('body').append(data.html);
                    $('.trustiful').on("click", function (e) {
                        $("#myModal").modal();

                    });



                }
            },
            'json'
        );
    });


}

if (window.jQuery) {
    a();

}

else {
    var script = document.createElement('script');
    script.src = 'https://code.jquery.com/jquery-3.3.1.min.js';
    script.type = 'text/javascript';

    var head = document.getElementsByTagName('head')[0];

    script.onload = function () {
        if (typeof jQuery === 'undefined') {
            alert('jquery still not present :(');
        }
        else {
            a();
        }
    };
    head.appendChild(script);

}