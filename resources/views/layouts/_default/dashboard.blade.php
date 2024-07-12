<!doctype html>
<html lang="en">

<head>
    @include('layouts.partials.header')
</head>

<body>
    @include('layouts.partials.navbar')
    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        @include('layouts.partials.sidebar')
        <div class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
            <div class="rounded-lg mt-2 mb-5">
                <main>
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>

</html>
