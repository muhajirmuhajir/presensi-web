<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Presensi Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('presensi.store')}}" method="POST">
                        @csrf
                        <div class="md:flex justify-between">
                            <div class="w-full px-2">
                                <div>
                                    <x-label for="kelas" :value="__('Kelas')" />

                                    <x-input id="kelas" class="block mt-1 w-full" name="kelas" :value="old('kelas')"
                                        required autofocus />
                                </div>
                                <div>
                                    <x-label for="topik" :value="__('topik')" />

                                    <x-input id="topik" class="block mt-1 w-full" name="topic" :value="old('topic')"
                                        required autofocus />
                                </div>
                                <div>
                                    <x-label for="question" :value="__('Pertanyaan Assesment')" />

                                    <x-textarea name="question" id="question" cols="5" class="block mt-1 w-full">
                                    </x-textarea>
                                </div>
                                <div class="md:flex py-2">
                                    <x-button>Terbitkan Presensi</x-button>
                                    <button type="reset"
                                        class="ml-10 underline text-sm text-gray-600 hover:text-gray-900"
                                        href="{{ route('login') }}">
                                        {{ __('Batalkan') }}
                                    </button>
                                </div>
                            </div>
                            <div class="w-full px-2">
                                <div>
                                    <x-label for="jam_buka" :value="__('Jam Buka')" />

                                    <x-input id="jam_buka" class="block mt-1 w-full" name="jam_buka"
                                        :value="old('jam_buka')" required autofocus />
                                </div>
                                <div>
                                    <x-label for="jam_tutup" :value="__('Jam Tutup')" />

                                    <x-input id="jam_tutup" class="block mt-1 w-full" name="jam_tutup"
                                        :value="old('jam_tutup')" required autofocus />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
