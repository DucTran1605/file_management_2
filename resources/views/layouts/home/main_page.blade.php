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
                            <form class="sm:pr-3" action="{{ route('file.search', ['parent_id' => $folder_id ?? '']) }}"
                                method="GET">
                                <label for="file-search" class="sr-only">Search</label>
                                <div class="relative w-48 sm:w-64 xl:w-96">
                                    <input type="text" name="file_search" id="file-search"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Search in drive" value="{{ request('file_search') }}">
                                    <button type="button" class="absolute inset-y-0 end-0 flex items-center pe-3"
                                        id="clear-search">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                            <!-- Settings Dropdown -->
                            <div class="hidden sm:flex sm:items-center sm:ms-1">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            <div>NEW</div>

                                            <div class="ms-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <form action="{{ route('file.upload', ['parent_id' => $folder_id ?? '']) }}"
                                            method="POST" enctype="multipart/form-data" id="image-upload">
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
                                @if (session()->has('cuted_file_id'))
                                    <form action="{{ route('file.paste', ['parent_id' => $folder_id ?? '']) }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" value="null" name="parent_id">
                                        <td><button
                                                class="ml-3 mt-2 text-black bg-white hover:bg-white focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 me-2 mb-2 dark:bg-white dark:hover:bg-white focus:outline-none dark:focus:ring-white">Paste</button>
                                        </td>
                                    </form>
                                @elseif (session()->has('copied_file_id'))
                                    <form action="{{ route('file.paste', ['parent_id' => $folder_id ?? '']) }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" value="null" name="parent_id">
                                        <td><button
                                                class="ml-3 mt-2 text-black bg-white hover:bg-white focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 me-2 mb-2 dark:bg-white dark:hover:bg-white focus:outline-none dark:focus:ring-white">Paste</button>
                                        </td>
                                    </form>
                                @endif
                                <!-- Modal Background (Hidden by Default) -->
                                <div id="modalBackdrop"
                                    class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50">
                                    <!-- Modal Content -->
                                    <div
                                        class="bg-white rounded-lg overflow-hidden shadow-lg max-w-md w-full dark:bg-gray-800">
                                        <div class="p-4 border-b dark:border-gray-700">
                                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">New Folder
                                            </h2>
                                        </div>
                                        <form action="{{ route('folder.create', ['parent_id' => $folder_id ?? '']) }}"
                                            enctype="multipart/form-data" method="POST">
                                            @csrf
                                            <div class="flex items-center justify-center w-full">
                                                <input type="text" id="default-input" name="folder_name"
                                                    class="mr-2 ml-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            </div>
                                            <div class="p-4 border-t flex justify-end dark:border-gray-700">
                                                <button type="submit"
                                                    class="px-4 py-2 bg-green-600 text-white rounded-md mr-2">Submit</button>
                                                <button id="closeModalBtn"
                                                    class="px-4 py-2 bg-red-600 text-white rounded-md"
                                                    type="button">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Error Messages -->
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="ml-2 flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                                        role="alert">
                                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                        </svg>
                                        <span class="sr-only">Info</span>
                                        <div>
                                            <span class="font-medium">Danger alert!</span> {{ $error }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
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
                    <!-- Modal Background (Hidden by Default) -->
                    <div id="modalBackdrop"
                        class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50">
                        <!-- Modal Content -->
                        <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-md w-full dark:bg-gray-800">
                            <div class="p-4 border-b dark:border-gray-700">
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Upload File</h2>
                            </div>
                            <div class="p-4 border-t flex justify-end dark:border-gray-700">
                                <button id="closeModalBtn"
                                    class="px-4 py-2 bg-red-600 text-white rounded-md">Close</button>
                            </div>
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
                                                    Uploaded
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
                                                                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path fill-rule="evenodd"
                                                                        d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Zm3 2h2.01v2.01h-2V8h2v2.01h-2V12h2v2.01h-2V16h2v2.01h-2v2H12V18h2v-1.99h-2V14h2v-1.99h-2V10h2V8.01h-2V6h2V4Z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            @endif
                                                            <a data-file-id={{ $file->id }}
                                                                onclick="showFileModal(event, '{{ Storage::disk('s3')->temporaryUrl($file->uploadName, now()->addMinutes(5)) }}', '{{ $fileExtension }}')">
                                                                {{ $file->name }}
                                                            </a>
                                                        @else
                                                            <a href="{{ route('folder.show', $file->id) }}"
                                                                class="flex items-center"><svg class="mr-2"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path fill-rule="evenodd"
                                                                        d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                {{ $file->name }}</a>
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
                                                        {{ $file->created_at->diffForHumans() }}
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
                                                                        action="{{ route('file.delete', $file->id) }}">
                                                                        @csrf
                                                                        @method('Delete')
                                                                        <x-dropdown-link :href="route('file.delete', $file->id)"
                                                                            onclick="event.preventDefault(); if (confirm('Are you sure you want to delete this file?')) { this.closest('form').submit(); }">
                                                                            {{ __('Delete') }}
                                                                        </x-dropdown-link>
                                                                    </form>

                                                                    <form method="POST"
                                                                        action="{{ route('file.cut', $file->id) }}">
                                                                        @csrf
                                                                        <x-dropdown-link :href="route('file.cut', $file->id)"
                                                                            onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                                            {{ __('Cut') }}
                                                                        </x-dropdown-link>
                                                                    </form>

                                                                    <form method="POST"
                                                                        action="{{ route('file.copy', $file->id) }}">
                                                                        @csrf
                                                                        <x-dropdown-link :href="route('file.copy', $file->id)"
                                                                            onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                                            {{ __('Copy') }}
                                                                        </x-dropdown-link>
                                                                    </form>

                                                                    <x-dropdown-link
                                                                        @click="$dispatch('set-file', {{ Js::from($file) }}); $dispatch('open-modal', 'file-detail-modal')">
                                                                        {{ __('File Detail') }}
                                                                    </x-dropdown-link>

                                                                    <x-dropdown-link>
                                                                        <input type="text" class="hidden"
                                                                            id="copy_{{ $file->id }}"
                                                                            value="{{ url('fileShare/'.$file->path) }}">
                                                                        <button value="copy"
                                                                            onclick="copyToClipboard('copy_{{ $file->id }}')">{{ __('Share file') }}</button>
                                                                    </x-dropdown-link>

                                                                    <x-dropdown-link :href="route('file.download', $file->id)">
                                                                        {{ __('Download') }}
                                                                    </x-dropdown-link>
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
        const openModalBtn = document.getElementById("openModalBtn");
        const closeModalBtn = document.getElementById("closeModalBtn");
        const modalBackdrop = document.getElementById("modalBackdrop");

        openModalBtn.addEventListener("click", () => {
            modalBackdrop.classList.remove("hidden");
        });

        closeModalBtn.addEventListener("click", () => {
            modalBackdrop.classList.add("hidden");
        });

        function copyToClipboard(id) {
            // Get the text field
            var copyText = document.getElementById(id);

            // Select the text field
            copyText.select();

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);

            alert("Copied share link: " + copyText.value);
        }

        document.getElementById('clear-search').addEventListener('click', function() {
            // Clear the search input field
            document.getElementById('file-search').value = '';
        });

        function showFileModal(event, fileUrl, fileExtension) {
            // Get the file ID from the data attribute
            const fileId = event.currentTarget.getAttribute('data-file-id');

            // Get the form element
            const downloadForm = document.getElementById('downloadForm');

            // Update the form's action attribute with the file download route
            downloadForm.action = `{{ url('/file/download/') }}/${fileId}`;

            const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
            const modal = document.getElementById('fileModal');
            const fileImage = document.getElementById('fileImage');
            const fileMessage = document.getElementById('fileMessage');
            const fileMessageBox = document.getElementById('fileMessageBox');

            if (imageExtensions.includes(fileExtension.toLowerCase())) {
                fileImage.src = fileUrl;
                fileImage.classList.remove('hidden');
            } else {
                fileImage.src = '';
                fileImage.classList.add('hidden');
                fileMessageBox.classList.remove('hidden');
                fileMessage.textContent = 'Cannot preview this file.';
            }

            modal.classList.remove('hidden');
        }

        function closeFileModal() {
            const modal = document.getElementById('fileModal');
            modal.classList.add('hidden');
        }
    </script>
    @include('layouts.partials.modal')
    @include('layouts.partials.fileImage_modal')
@endsection
