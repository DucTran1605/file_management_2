<!doctype html>
<html lang="en">

<head>
    @include('layouts.partials.header')
</head>

<body>
    @include('layouts.partials.navbar')
    @include('layouts.partials.sidebar')
    <div class="sm:ml-64">
        <div class="rounded-lg mt-14">
            <main>
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
