@extends('layouts._default.dashboard')
@section('content')
    <div class="min-h-screen">
        <div class="grid grid-cols-2">
            <div class="flex items-center justify-start bg-gray-50 h-28 dark:bg-gray-800">
                <div class="items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700 ml-2">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <form class="sm:pr-3" action="#" method="GET">
                            <label for="products-search" class="sr-only">Search</label>
                            <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                                <input type="text" name="email" id="products-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search in drive">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>NEW</div>

                                <div class="ms-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 12h14m-7 7V5" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data"
                                id="image-upload">
                                @csrf
                                <button
                                    class="btn block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                    id="file_button" name="file_button" type="button"
                                    onclick="document.getElementById('file_input').click();">
                                    Upload File
                                </button>
                                <input class="hidden" id="file_input" name="file" type="file"
                                    onchange="document.getElementById('image-upload').submit();">
                            </form>

                            <button id="openModalBtn"
                                class="btn block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Create
                                folder
                            </button>
                        </x-slot>
                    </x-dropdown>
                    <!-- Modal Background (Hidden by Default) -->
                    <div id="modalBackdrop"
                        class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50">
                        <!-- Modal Content -->
                        <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-md w-full dark:bg-gray-800">
                            <div class="p-4 border-b dark:border-gray-700">
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">New Folder</h2>
                            </div>
                            <form action="{{ route('folder.create') }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="flex items-center justify-center w-full">
                                    <input type="text" id="default-input" name="folder_name"
                                        class="mr-2 ml-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                <div class="p-4 border-t flex justify-end dark:border-gray-700">
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-600 text-white rounded-md mr-2">Submit</button>
                                    <button id="closeModalBtn"
                                        class="px-4 py-2 bg-red-600 text-white rounded-md">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal Background (Hidden by Default) -->
                <div id="modalBackdrop"
                    class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50">
                    <!-- Modal Content -->
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-md w-full dark:bg-gray-800">
                        <div class="p-4 border-b dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Upload File</h2>
                        </div>
                        <div class="p-4 border-t flex justify-end dark:border-gray-700">
                            <button id="closeModalBtn" class="px-4 py-2 bg-red-600 text-white rounded-md">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end bg-gray-50 h-28 dark:bg-gray-800">
            </div>
        </div>
        <div class="flex items-start bg-gray-50 dark:bg-gray-800 min-h-screen">
            <div class="w-full">
                <table class="w-full max-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                File name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Size
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Uploaded
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="ml-4">Action</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $file)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 flex font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @php
                                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                        $textExtensions = ['txt', 'md', 'csv', 'log', 'json', 'xml', 'html'];
                                        $fileExtension = $file->extension;
                                    @endphp
                                    @if (in_array($fileExtension, $imageExtensions))
                                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Zm.394 9.553a1 1 0 0 0-1.817.062l-2.5 6A1 1 0 0 0 8 19h8a1 1 0 0 0 .894-1.447l-2-4A1 1 0 0 0 13.2 13.4l-.53.706-1.276-2.553ZM13 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @elseif (in_array($fileExtension, $textExtensions))
                                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                    {{ $file->name }}.{{ $file->extension }}
                                </th>
                                <td class="px-6 py-4">
                                    @if ($file->size == "")
                                        {{ $file->size }}
                                    @else
                                        {{ number_format($file->size / 1024) }} KB
                                    @endif

                                </td>
                                <td class="px-6 py-4">
                                    {{ $file->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4">
                                    <!-- Settings Dropdown -->
                                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button>
                                                    <div class="ms-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-width="3" d="M12 6h.01M12 12h.01M12 18h.01" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <!-- Delete File -->
                                                <form method="POST" action="{{ route('file.delete', $file->id) }}">
                                                    @csrf
                                                    @method('Delete')
                                                    <x-dropdown-link :href="route('file.delete', $file->id)"
                                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                        {{ __('Delete') }}
                                                    </x-dropdown-link>
                                                </form>

                                                <x-dropdown-link
                                                    @click="$dispatch('set-file', {{ Js::from($file) }}); $dispatch('open-modal', 'file-detail-modal')">
                                                    {{ __('File Detail') }}
                                                </x-dropdown-link>
                                            </x-slot>
                                        </x-dropdown>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('layouts.partials.modal')
@endsection
