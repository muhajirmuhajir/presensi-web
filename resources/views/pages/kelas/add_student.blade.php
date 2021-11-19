<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambahkan Siswa Pada Kelas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('kelas.student.store', $kelas->id)}}" method="POST">
                        @csrf

                        <div>
                            <x-label for="name" :value="__('Nama Kelas')" />

                            <x-input id="name" type="text" class="block mt-1 w-full" name="name"
                                value="{{$kelas->name}}" required disabled />
                        </div>
                        <div class="mt-4">
                            <x-label for="student_id" :value="__('Nama Siswa')" />
                            <x-select name="student_id" id="student_id" class="block mt-1 w-full" required autofocus>
                                @foreach ($students as $student)
                                <option value="{{$student->id}}">{{$student->name}}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="md:flex py-2">
                            <x-button>Tambah Siswa</x-button>
                            <button type="reset" class="ml-10 underline text-sm text-gray-600 hover:text-gray-900">
                                {{ __('Batalkan') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
