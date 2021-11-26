<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengumuman') }}
        </h2>
        <p class="text-gray-400 text-sm font-light">oleh : {{auth()->user()->name}}</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('pengumuman.update', $pengumuman)}}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div>
                            <x-label for="course_name" :value="__('Judul')" />

                            <x-input id="course_name" type="text" class="block mt-1 w-full cursor-not-allowed"
                                name="course_name" value="{{$pengumuman->course->fullname()}}" required disabled />
                        </div>
                        <div class="mt-4">
                            <x-label for="title" :value="__('Judul')" />

                            <x-input id="title" type="text" class="block mt-1 w-full" name="title"
                                value="{{$pengumuman->title}}" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-label for="body" :value="__('Content')" />
                            <x-textarea name="body" id="body" rows="8" class="block mt-1 w-full">
                                {{$pengumuman->body}}
                            </x-textarea>
                        </div>
                        <div class="mt-4">
                            <div class="grid sm:grid-cols-3">
                                <div class="rounded p-4 bg-gray-200">
                                    <img src="{{Storage::url($pengumuman->thumbnail_url)}}" alt="" srcset=""
                                        class="w-full">
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-label for="thumbnail" :value="__('Update Thumbnail')" />
                            <x-input id="thumbnail" type="file" class="block mt-1 w-full" name="thumbnail"
                                :value="old('title')" autofocus />
                        </div>
                        <div class="md:flex py-2 items-center">
                            <x-button>Update Pengumuman</x-button>
                            <a class="ml-10 underline text-sm text-gray-600 hover:text-gray-900"
                                href="{{ route('pengumuman.index') }}">
                                {{ __('Batalkan') }}
                            </a>

                        </div>

                    </form>
                    <form action="{{route('pengumuman.destroy', $pengumuman)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus Pengumuman?')"
                            class=" underline text-sm text-red-600 hover:text-gray-900">
                            {{ __('Hapus') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
