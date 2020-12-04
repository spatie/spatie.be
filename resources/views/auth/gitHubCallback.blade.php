<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Logged in using GitHub!</title>
</head>
<body>
<h1>Redirecting...</h1>
<script>
    if (window.opener && window.opener !== window) {
        // This is an auth popup. We can close this window and
        // the parent window will take care of the user.
        window.close();
    } else {
        window.location.replace('{{ session('next', route('products.index')) }}');
    }
</script>
</body>
</html>
