<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengumuman Baru') }}
        </h2>
        <p class="text-gray-400 text-sm font-light">oleh : {{auth()->user()->name}}</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('pengumuman.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @role(config('enums.roles.teacher'))
                        <div>
                            <x-label for="course_id" :value="__('Kelas')" />
                            <x-select name="course_id" id="course_id" class="block mt-1 w-full" required autofocus>
                                @foreach ($courses as $course)
                                <option value="{{$course->id}}">{{$course->name}}</option>
                                @endforeach
                            </x-select>
                        </div>
                        @endrole
                        <div class="mt-4">
                            <x-label for="title" :value="__('Judul')" />

                            <x-input id="title" type="text" class="block mt-1 w-full" name="title" :value="old('title')"
                                required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-label for="body" :value="__('Content')" />
                            <x-textarea name="body" id="body" rows="8" class="block mt-1 w-full">
                            </x-textarea>
                        </div>
                        <div class="mt-4">
                            <x-label for="thumbnail" :value="__('Thumbnail')" />
                            <x-input id="thumbnail" type="file" class="block mt-1 w-full" name="thumbnail"
                                :value="old('title')" required autofocus />
                        </div>
                        <div class="md:flex py-2">
                            <x-button>Terbitkan Pengumuman</x-button>
                            <button type="reset" class="ml-10 underline text-sm text-gray-600 hover:text-gray-900"
                                href="{{ route('login') }}">
                                {{ __('Batalkan') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
