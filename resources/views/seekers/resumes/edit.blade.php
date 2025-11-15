<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                     <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <h3 class="text-3xl font-bold dark:text-gray-500 mb-6">Profesional Information</h3>
                    </div>
                    <div>
                        <x-avatar :user="$resume->avatar" class="rounded w-36 h-36 float-right" alt="Avatar"/>
                    </div>
                     </div>
                    <form action="{{ route('resumes.update', $resume->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-6 mb-6 md:grid-cols-3">
                            <div>
                                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" id="first_name" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" value="{{$resume->first_name}}" @if($resume->first_name == null) placeholder = "No Record Found" @endif required>
                            </div>
                            <div>
                                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" name="last_name" id="last_name" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" value="{{$resume->last_name}}" @if($resume->last_name == null) placeholder = "No Record Found" @endif required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                                <input type="file" name="avatar" id="avatar" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500"  >
                            </div>
                        </div>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="profession" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Profession <span class="text-red-500">*</span></label>
                                <input type="text" name="profession" id="profession" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" value="{{$resume->profession}}" @if($resume->profession == null) placeholder = "No Record Found" @endif required>
                            </div>
                            <div>
                                <label for="language" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Language <span class="text-red-500">*</span></label>
                                <input type="text" name="language" id="language" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" value="{{$resume->language}}" @if($resume->language == null) placeholder = "No Record Found" @endif  required>
                            </div>
                        </div>
                        <div class="grid gap-6 mb-6 md:grid-cols-3">
                            <div>
                                <label for="country" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Country <span class="text-red-500">*</span></label>
                                <select name="country" id="country" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option selected>{{ $resume->country }}</option>
                                    @foreach ($countries as $country )
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                  </select>
                            </div>
                            <div>
                                <label for="state" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">State <span class="text-red-500">*</span></label>
                                <select name="state" id="state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option selected> --- </option>
                                    @foreach ($states as $state )
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">City <span class="text-red-500">*</span></label>
                                <input type="text" name="city" id="city" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" value="{{$resume->city}}" @if($resume->city == null) placeholder = "No Record Found" @endif required>
                                {{-- <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option selected>Choose a City</option>
                                    @foreach ($cities as $city )
                                    <option value="{{ $city->name }}">{{ $city->name }}</option>
                                    @endforeach
                                  </select> --}}
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Address <span class="text-red-500">*</span></label>
                            <input type="text" name="address" id="address" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" value="{{$resume->address}}" @if($resume->address == null) placeholder = "No Record Found" @endif required>
                        </div>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="phone_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Phone No <span class="text-red-500">*</span></label>
                                <input type="text" name="phone_no" id="phone_no" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" value="{{$resume->phone_no}}" @if($resume->phone_no == null) placeholder = "No Record Found" @endif required>
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Email <span class="text-red-500">*</span></label>
                                <input type="text" name="email" id="email" class="bg-white-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5  dark:placeholder-gray-400 dark:text-gray-500" value="{{$resume->email}}" @if($resume->email == null) placeholder = "No Record Found" @endif required>
                            </div>
                        </div>
                        <button id="submit" type="submit" class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 float-right">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function(){
        $("#country").change(function(){
            let country_id = this.value;
            $.get('/get_states?country='+country_id, function(data){
                console.log(data);
            })
        })
    })
</script>
