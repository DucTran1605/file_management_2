@extends('layouts._default.dashboard')
@section('content')
    <div class="min-h-screen">
        <div class="px-4 pt-6">
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <!-- Card header -->
                <div class="items-center justify-between lg:flex">
                    <div class="items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700 ml-2">
                        <div class="flex items-center mb-4 sm:mb-0">
                            <form class="sm:pr-3" action="{{ route('fileTrash.search', ['parent_id' => $folder_id ?? '']) }}"
                                method="GET" enctype="multipart/form-data">
                                @csrf
                                <label for="products-search" class="sr-only">Search</label>
                                <div class="relative w-48 sm:w-64 xl:w-96">
                                    <input type="text" name="file_search" id="file-search"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Search in drive">
                                </div>
                            </form>
                            @if (session()->has('message'))
                                <div class="flex items-center p-4 ml-1 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                                    role="alert">
                                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <div>
                                        <span class="font-medium">Success!</span> {{ session()->get('message') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Table -->
                <div class="flex flex-col mt-6">
                    <div class="overflow-x-auto rounded-lg">
                        <div class="inline-block min-w-full align-middle min-h-screen">
                            <div class="overflow-hidden shadow sm:rounded-lg">
                                <div class="w-full">
                                    <table class="w-full max-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th scope="col"
                                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                    ID
                                                </th>
                                                <th scope="col"
                                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                    File name
                                                </th>
                                                <th scope="col"
                                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                    Size
                                                </th>
                                                <th scope="col"
                                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                    Deleted at
                                                </th>
                                                <th scope="col"
                                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800">
                                            @foreach ($files as $file)
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <td
                                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                        {{ $file->id }}
                                                    </td>
                                                    <th scope="row"
                                                        class="px-6 py-4 flex text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                                        @php
                                                            $imageExtensions = [
                                                                'jpg',
                                                                'jpeg',
                                                                'png',
                                                                'gif',
                                                                'bmp',
                                                                'webp',
                                                            ];
                                                            $textExtensions = [
                                                                'txt',
                                                                'md',
                                                                'csv',
                                                                'log',
                                                                'json',
                                                                'xml',
                                                                'html',
                                                            ];
                                                            $pdfExtensions = ['pdf'];
                                                            $specialExtensions = ['zip', 'rar'];
                                                            $fileExtension = $file->extension;
                                                        @endphp
                                                        @if ($file->type == 'file')
                                                            @if (in_array($fileExtension, $imageExtensions))
                                                                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path fill-rule="evenodd"
                                                                        d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Zm.394 9.553a1 1 0 0 0-1.817.062l-2.5 6A1 1 0 0 0 8 19h8a1 1 0 0 0 .894-1.447l-2-4A1 1 0 0 0 13.2 13.4l-.53.706-1.276-2.553ZM13 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            @elseif (in_array($fileExtension, $textExtensions))
                                                                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path fill-rule="evenodd"
                                                                        d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            @elseif (in_array($fileExtension, $specialExtensions))
                                                                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path fill-rule="evenodd"
                                                                        d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Zm3 2h2.01v2.01h-2V8h2v2.01h-2V12h2v2.01h-2V16h2v2.01h-2v2H12V18h2v-1.99h-2V14h2v-1.99h-2V10h2V8.01h-2V6h2V4Z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            @elseif (in_array($fileExtension, $pdfExtensions))
                                                                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path fill-rule="evenodd"
                                                                        d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11H11Zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626H12Zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2h-2Z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            @endif
                                                            {{ $file->name }}
                                                        @else
                                                            <svg class="mr-2" xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path fill-rule="evenodd"
                                                                    d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            {{ $file->name }}
                                                        @endif
                                                    </th>
                                                    <td
                                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                        @if ($file->size == '')
                                                            <label for="" class="ml-2">-</label>
                                                        @else
                                                            {{ number_format($file->size / 1024) }} KB
                                                        @endif
                                                    </td>
                                                    <td
                                                        class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $file->deleted_at }}
                                                    </td>
                                                    <td
                                                        class="absolute mt-3 p-1 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                        <!-- Settings Dropdown -->
                                                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                                                            <x-dropdown align="right" width="48">
                                                                <x-slot name="trigger">
                                                                    <button>
                                                                        <div class="ms-1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                fill="none" viewBox="0 0 24 24">
                                                                                <path stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-width="3"
                                                                                    d="M12 6h.01M12 12h.01M12 18h.01" />
                                                                            </svg>
                                                                        </div>
                                                                    </button>
                                                                </x-slot>

                                                                <x-slot name="content">
                                                                    <!-- Delete File -->
                                                                    <form method="POST"
                                                                        action="{{ route('file.forceDelete', $file->id) }}">
                                                                        @csrf
                                                                        @method('Delete')
                                                                        <x-dropdown-link :href="route('file.forceDelete', $file->id)"
                                                                            onclick="event.preventDefault(); if (confirm('Are you sure you want to delete this file? \n File after delete cannot restore')) { this.closest('form').submit(); }">
                                                                            {{ __('Delete') }}
                                                                        </x-dropdown-link>
                                                                    </form>

                                                                    <form action="{{ route('files.restore', $file->id) }}">
                                                                        <x-dropdown-link :href="route('files.restore', $file->id)"
                                                                            onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                                                            {{ __('Restore File') }}
                                                                        </x-dropdown-link>
                                                                    </form>
                                                                </x-slot>
                                                            </x-dropdown>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $files->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function copyToClipboard(id) {
            // Get the text field
            var copyText = document.getElementById(id);

            // Select the text field
            copyText.select();

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);

            alert("Copied share link: " + copyText.value);
        }
    </script>
    @include('layouts.partials.modal')
@endsection
