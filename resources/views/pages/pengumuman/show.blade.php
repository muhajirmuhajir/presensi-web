<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $pengumuman->title }}
        </h2>
        <p class="text-gray-400 text-sm font-light">oleh : {{auth()->user()->name}}</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <img src="{{Storage::url($pengumuman->thumbnail_url)}}" alt="Thumbnail" class="w-full">
                    <div class="mt-4">
                        <p class="text-lg font-light">
                            {{$pengumuman->body}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
