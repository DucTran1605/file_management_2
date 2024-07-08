@extends('layouts._default.dashboard')
@section('content')
    <div class="min-h-screen">
        <div class="px-4 pt-6">
            <div class="grid w-full grid-cols-1 gap-4 mt-4 my-4 xl:grid-cols-2 2xl:grid-cols-3">
                <div
                    class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <div class="w-full">
                        <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">File</h3>
                        <span
                            class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{ $filesCount }}</span>
                    </div>
                    <div class="w-full" id="new-products-chart"></div>
                </div>
                <div
                    class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <div class="w-full">
                        <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Folder</h3>
                        <span
                            class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{ $foldersCount }}</span>
                    </div>
                    <div class="w-full" id="week-signups-chart"></div>
                </div>
                <div
                    class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <div class="w-full">
                        <h3 class="mb-2 text-base font-normal text-gray-500 dark:text-gray-400">Audience by age</h3>
                        <div class="flex items-center mb-2">
                            <div class="w-16 text-sm font-medium dark:text-white">50+</div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                <div class="bg-primary-600 h-2.5 rounded-full dark:bg-primary-500" style="width: 18%">
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center mb-2">
                            <div class="w-16 text-sm font-medium dark:text-white">40+</div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                <div class="bg-primary-600 h-2.5 rounded-full dark:bg-primary-500" style="width: 15%">
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center mb-2">
                            <div class="w-16 text-sm font-medium dark:text-white">30+</div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                <div class="bg-primary-600 h-2.5 rounded-full dark:bg-primary-500" style="width: 60%">
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center mb-2">
                            <div class="w-16 text-sm font-medium dark:text-white">20+</div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                <div class="bg-primary-600 h-2.5 rounded-full dark:bg-primary-500" style="width: 30%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="traffic-channels-chart" class="w-full"></div>
                </div>
            </div>
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <!-- Table -->
                <div class="min-h-screen">
                    <div class="flex flex-col mt-2">
                        <div class="overflow-x-auto rounded-lg">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden shadow sm:rounded-lg">
                                    <div class="w-full">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                            <thead class="bg-gray-50 dark:bg-gray-700">
                                                <tr>
                                                    <th scope="col"
                                                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                        File name
                                                    </th>
                                                    <th scope="col"
                                                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                        Event
                                                    </th>
                                                    <th scope="col"
                                                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                        Uploaded
                                                    </th>
                                                    <th scope="col"
                                                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                        Owner
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-gray-800">
                                                @foreach ($activities as $activity)
                                                    <tr>
                                                        <th scope="row"
                                                            class="px-6 py-4 p-4 flex text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
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
                                                                $fileExtension = $activity->subject->extension;
                                                            @endphp
                                                            @if ($activity->subject->type == 'file')
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
                                                                @endif
                                                                {{ $activity->subject ? $activity->subject->name : 'N/A' }}
                                                            @else
                                                                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path fill-rule="evenodd"
                                                                        d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                {{ $activity->subject ? $activity->subject->name : 'N/A' }}
                                                            @endif
                                                        </th>
                                                        <td
                                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                            {{ $activity->description }}
                                                        </td>
                                                        <td
                                                            class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                                            {{ $activity->created_at }}
                                                        </td>
                                                        <td
                                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                            {{ $activity->causer->name }}s
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $activities->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
