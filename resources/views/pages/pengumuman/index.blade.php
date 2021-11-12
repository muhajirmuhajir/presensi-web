<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('List Pengumuman') }}
            </h2>
            <form action="{{route('pengumuman.create')}}">
                <x-button>Buat Pengumuman</x-button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid md:grid-cols-3 gap-2">
                        @foreach ($data as $item)
                        <div class="card-container p-4 rounded-sm bg-gray-50">
                            <img class="w-full" src="{{Storage::url($item->thumbnail_url)}}" alt="">
                            <div class="card-content">
                                <h4 class="text-lg"><a href="{{route('pengumuman.show', $item)}}">{{$item->title}}</a>
                                </h4>
                                <p class="text-sm text-gray-400 font-light">kelas .</p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
