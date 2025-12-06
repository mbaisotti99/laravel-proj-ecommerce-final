<!DOCTYPE html>
<html lang="it">

<head>
@vite(['resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("titolo")</title>
</head>

<body>

    @include("partials.header")

    <main>
        @yield("contenuto")
    </main>


    @include("partials.footer")

</body>

</html>