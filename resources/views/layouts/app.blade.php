<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Tiket</title>
   <!-- Bootstrap CSS (jika pakai Bootstrap) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Main Content --}}
    @if (Request::is('/'))
        {{-- Home page tanpa container --}}
        @yield('content')
    @else
        <div class="container mx-auto px-6 py-8">
            @yield('content')
        </div>
    @endif

</body>
</html>
