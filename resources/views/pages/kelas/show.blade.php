<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Kelas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <x-label for="kelas" :value="__('Nama Kelas')" />
                        <x-input id="kelas" type="text" class="block mt-1 w-full" name="kelas" value="{{$kelas->name}}"
                            disabled />
                    </div>
                    <div class="mt-4">
                        <x-label for="topic" :value="__('Jumlah Mata Pelajaran')" />
                        <x-input id="topic" type="text" class="block mt-1 w-full" name="topic"
                            value="{{$kelas->courses_count}}" disabled />
                    </div>
                    <div class="mt-4">
                        <x-label for="student" :value="__('Jumlah Siswa')" />
                        <x-input id="student" type="text" class="block mt-1 w-full" name="student"
                            value="{{$kelas->students_count}}" disabled />
                    </div>
                    @role(config('enums.roles.bk'))
                    <div class="my-4 flex gap-4 items-center">
                        <x-button-link href="{{route('kelas.edit', $kelas)}}">Edit</x-button-link>
                        <form action="{{route('kelas.destroy', $kelas)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button
                                onclick="return confirm('Hapus Kelas akan menghapus semua mata pelajaran termasuk riwayat presensi, Lanjutkan?')"
                                class="bg-none underline text-sm" type="submit">Hapus</button>
                        </form>
                    </div>
                    @endrole
                    <hr>
                    <h3 class="text-xl mt-6">List Mata Pelajaran</h3>

                    <section class="container mx-auto py-12">
                        <div class="w-full mb-8 overflow-hidden rounded-sm shadow-lg">
                            <div class="w-full">
                                <table class="w-full">
                                    <thead>
                                        <tr
                                            class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-200 uppercase border-b border-gray-600">
                                            <th class="px-4 py-3">No</th>
                                            <th class="px-4 py-3">Mata Pelajaran</th>
                                            <th class="px-4 py-3">Guru</th>
                                            <th class="px-4 py-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($kelas->courses as $i => $item)
                                        <tr class="text-gray-700">
                                            <td class="px-4 py-3 border">{{$i+1}}</td>
                                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->name}}
                                            </td>
                                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->teacher->name}}
                                            </td>
                                            <td class="px-4 py-3 text-ms font-semibold border">
                                                <a href="{{route('course.show', $item)}}">Detail</a>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                    <hr>
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl mt-6">List Siswa</h3>
                        <x-button-link href="{{route('kelas.student.add', $kelas->id)}}">Tambah Siswa</x-button-link>
                    </div>

                    <section class="container mx-auto py-12">
                        <div class="w-full mb-8 overflow-hidden rounded-sm shadow-lg">
                            <div class="w-full">
                                <table class="w-full">
                                    <thead>
                                        <tr
                                            class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-200 uppercase border-b border-gray-600">
                                            <th class="px-4 py-3">No</th>
                                            <th class="px-4 py-3">Nama</th>
                                            <th class="px-4 py-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($kelas->students as $i => $item)
                                        <tr class="text-gray-700">
                                            <td class="px-4 py-3 border">{{$i+1}}</td>
                                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->name}}
                                            </td>
                                            <td class="px-4 py-3 text-ms font-semibold border">
                                                <div class="flex gap-4">
                                                    {{-- <a href="{{route('student.show', $item)}}">Detail</a> --}}
                                                    <form action="{{route('kelas.student.destroy',[$kelas,$item])}}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('Hapus Siswa dari kelas?')"
                                                            type="submit">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
