<!doctype html>
<html lang="en">

<head>
    @include('layouts.partials.header')

</head>

<body>
    @include('layouts.partials.navbar')
    @include('layouts.partials.sidebar')
    <main class="pt-4 pb-4 content pt-lg-xl">
        @yield('content')
    </main>
</body>

</html>
