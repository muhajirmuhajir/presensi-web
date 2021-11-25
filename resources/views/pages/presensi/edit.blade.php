<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Presensi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('presensi.update', $presensi)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-label for="topic" :value="__('Mata Pelajaran')" />
                            <x-input id="topic" type="text" class="block mt-1 w-full cursor-not-allowed" name="topic"
                                value="{{$presensi->fullname()}}" disabled />
                        </div>
                        <div class="mt-4">
                            <x-label for="topic" :value="__('Topik')" />
                            <x-input id="topic" type="text" class="block mt-1 w-full" name="topic"
                                value="{{$presensi->topic}}" />
                        </div>
                        <div class="mt-4">
                            <x-label for="question" :value="__('Pertanyaan')" />
                            <x-textarea name="question" id="question" cols="5" class="block mt-1 w-full">
                                {{$presensi->question ?? "-"}}
                            </x-textarea>
                        </div>
                        <div class="mt-4">
                            <x-button>Update Presensi</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
