<x-modal name="file-detail-modal" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <!-- Modal content -->
    <div x-data="{
        file: {
            id: null, name: '', size: 0, type: '', created_at: ''
        },
        updateUrl() {
            return `/fileEdit/${this.file.id}`;
        }
    }" class="relative bg-white rounded-lg shadow dark:bg-gray-700" @set-file.window="file=$event.detail;">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ __('File Infomation') }}
            </h3>
            <button x-on:click="$dispatch('close')" type="button"
                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="authentication-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5">
            <form class="space-y-4" :action="updateUrl" method="POST">
                @method('PUT')
                @csrf()
                <div>
                    <label for="fileName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">File
                        Name</label>
                    <input name="name"
                    x-model="file.name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                         placeholder="" />
                </div>
                <div>
                    <label for="fileSize" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Size
                        (KB)
                    </label>
                    <input name="size"
                    x-model="file.size"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        readonly placeholder="" />
                </div>
                <div>
                    <label for="fileType" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type
                    </label>
                    <input name="type"
                    x-model="file.type"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        readonly placeholder="" />
                </div>
                <div>
                    <label for="fileType" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload date
                    </label>
                    <input name="date"
                    x-model="file.created_at"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        readonly placeholder="" />
                </div>
                <button type="submit"
                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save
                </button>
            </form>
        </div>
    </div>
</x-modal>