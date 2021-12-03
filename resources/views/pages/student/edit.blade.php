<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Akun Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg relative">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('student.update', $student)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid md:grid-cols-2 gap-2">
                            <div>
                                <x-label for="name" :value="__('Nama')" />

                                <x-input id="name" type="text" class="block mt-1 w-full" name="name"
                                    value="{{$student->name}}" required autofocus />
                            </div>
                            <div>
                                <x-label for="identity_number" :value="__('Nomor Induk Siswa')" />

                                <x-input id="identity_number" type="text" class="block mt-1 w-full"
                                    name="identity_number" value="{{$student->identity_number}}" required autofocus />
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" type="email" class="block mt-1 w-full" name="email"
                                value="{{$student->email}}" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-label for="phone_number" :value="__('No Handphone')" />

                            <x-input id="phone_number" type="text" class="block mt-1 w-full" name="phone_number"
                                value="{{$student->phone_number}}" required autofocus />
                        </div>
                        <div class="md:flex py-2">
                            <x-button>Update Akun</x-button>
                            <a class="ml-10 underline text-sm text-gray-600 hover:text-gray-900"
                                href="{{ route('student.index') }}">
                                {{ __('Batalkan') }}
                            </a>
                        </div>

                    </form>
                </div>
                <div class="absolute bottom-5 right-5">
                    <form action="{{route('student.destroy',$student )}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus Akun Siswa?')"
                            class="underline text-sm text-gray-600 hover:text-gray-900" type="submit">Hapus
                            Akun</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>