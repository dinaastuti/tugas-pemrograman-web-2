@props(['title' => 'Data Makanan'])

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @vite('resources/js/app.js')
</head>
<body>
    <div class="bg-primary py-5 text-center text-white">
        <h1 class="fw-bold">{{ $title }}</h1>
    </div>

    <main class="container my-5">
        @if (session('success'))
            <p class="alert alert-success" role="status">
                {{ session('success') }}
            </p>
        @endif

        {{ $slot }}
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/B2ScQbITxI" crossorigin="anonymous">
    </script>
</body>
</html>
