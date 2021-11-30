<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Kelas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('kelas.update', $kelas)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mt-4">
                            <x-label for="name" :value="__('Nama Kelas')" />

                            <x-input id="name" type="text" class="block mt-1 w-full" name="name"
                                value="{{$kelas->name}}" required autofocus />
                        </div>
                        <div class="md:flex py-2">
                            <x-button>Update Kelas</x-button>
                            <a href="{{route('kelas.show', $kelas)}}"
                                class="ml-10 underline text-sm text-gray-600 hover:text-gray-900">
                                {{ __('Batalkan') }}
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
