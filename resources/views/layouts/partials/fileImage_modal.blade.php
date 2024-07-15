<!-- Main modal -->
<div id="fileModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center ">
    <div class="fixed inset-0 bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-screen max-h-screen">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 rounded-t">
                <form id="downloadForm" method="get">
                    <!-- The action attribute will be modified via JavaScript -->
                    <button type="submit"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.374a1 1 0 1 0-1.56 1.25l4 5a1 1 0 0 0 1.56 0l4-5a1 1 0 1 0-1.56-1.25L13 11.15Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M9.657 15.874 7.358 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2.358l-2.3 2.874a3 3 0 0 1-4.685 0ZM17 16a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    onclick="closeFileModal()">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="flex flex-col items-center justify-center p-4 md:p-5">
                <img id="fileImage" class="hidden" alt="File Image" />
            </div>
            <div id="fileMessageBox" class="hidden flex flex-col items-center justify-center p-10 md:p-20">
                <div class="relative p-6 w-full max-w-3xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 m-10 text-center">
                        <div class="p-4 md:p-5 space-y-4">
                            <h3 id="fileMessage" class="text-xl font-semibold text-gray-900 dark:text-white">
                            </h3>
                        </div>
                        <!-- Modal footer -->
                        <div
                            class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <form id="downloadForm" method="get">
                                <!-- The action attribute will be modified via JavaScript -->
                                <button type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    Download
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
