<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>404 Page Not Found</title>

    <!-- Google font -->
    <link href="//fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('404/css/style.css') }}" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        (function () {
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
        })();
    </script>
</head>

<body>

<div id="notfound">
    <div class="notfound">
        <div class="notfound-404">
            <h1>Oops!</h1>
        </div>
        <h2>404 - Page not found</h2>
        <p>The page you are looking for might have been not permission for the access and it's temporarily unavailable.</p>
        <a href="/dashboard">Go To Dashboard</a>
    </div>
</div>

</body>

</html>
