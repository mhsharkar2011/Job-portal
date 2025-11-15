<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <h3 class="text-3xl font-bold dark:text-gray-500 mb-6">Profesional Information</h3>
                    </div>
                    <form>
                        <div class="grid gap-6 mb-6 md:grid-cols-3">
                            <div>
                                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">First Name <span class="text-red-500">*</span></label>
                                <input type="text" id="first_name" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" placeholder="Enter First Name" required>
                            </div>
                            <div>
                                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" id="last_name" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" placeholder="Enter Last Name" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                                <input class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" name="avatar" id="file_input" type="file">
                            </div>
                        </div>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Profession <span class="text-red-500">*</span></label>
                                <input type="text" id="first_name" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" placeholder="Enter Your Profession" required>
                            </div>
                            <div>
                                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Language <span class="text-red-500">*</span></label>
                                <input type="text" id="first_name" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" placeholder="Enter Language" required>
                            </div>
                        </div>
                        <div class="grid gap-6 mb-6 md:grid-cols-3">
                            <div>
                                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Country <span class="text-red-500">*</span></label>
                                <input type="text" id="first_name" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" placeholder="Enter Your Country" required>
                            </div>
                            <div>
                                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">State <span class="text-red-500">*</span></label>
                                <input type="text" id="first_name" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" placeholder="Enter Your State" required>
                            </div>
                            <div>
                                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">City <span class="text-red-500">*</span></label>
                                <input type="text" id="first_name" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" placeholder="Enter Your City" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Address <span class="text-red-500">*</span></label>
                            <input type="text" name="address" id="first_name" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" placeholder="Enter Your Address" required>
                        </div>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Phone No <span class="text-red-500">*</span></label>
                                <input type="text" name="address" id="first_name" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" placeholder="Enter Your Phone No" required>
                            </div>
                            <div>
                                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Email <span class="text-red-500">*</span></label>
                                <input type="text" name="address" id="first_name" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" placeholder="Enter Your Email" required>
                            </div>
                        </div>
                        <button type="submit" class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 float-right">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
