<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Mata Pelajaran') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <x-label for="topic" :value="__('Mata Pelajaran')" />
                        <x-input id="topic" type="text" class="block mt-1 w-full" name="topic" value="{{$course->name}}"
                            disabled />
                    </div>
                    <div class="mt-4">
                        <x-label for="kelas" :value="__('Nama Kelas')" />

                        <x-input id="topic" type="text" class="block mt-1 w-full" name="kelas"
                            value="{{$course->kelas->name}}" disabled />
                    </div>
                    <div class="mt-4">
                        <x-label for="kelas" :value="__('Nama Guru')" />

                        <x-input id="topic" type="text" class="block mt-1 w-full" name="kelas"
                            value="{{$course->teacher->name}}" disabled />
                    </div>
                    <div class="mt-4">
                        <x-label for="topic" :value="__('Jumlah Siswa')" />
                        <x-input id="topic" type="text" class="block mt-1 w-full" name="topic"
                            value="{{$course->students_count}}" disabled />
                    </div>
                    @role(config('enums.roles.bk'))
                    <div class="my-4 flex gap-4 items-center">
                        <x-button-link href="{{route('course.edit', $course)}}">Edit</x-button-link>
                        <form action="{{route('course.destroy', $course)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus Course?')" class="bg-none underline text-sm"
                                type="submit">Hapus</button>
                        </form>
                    </div>
                    @endrole
                    <hr>
                    <h3 class="text-xl mt-6">Riwayat Presensi</h3>

                    <section class="container mx-auto py-12">
                        <div class="w-full mb-8 overflow-hidden rounded-sm shadow-lg">
                            <div class="w-full">
                                <table class="w-full">
                                    <thead>
                                        <tr
                                            class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-200 uppercase border-b border-gray-600">
                                            <th class="px-4 py-3">No</th>
                                            <th class="px-4 py-3">Materi</th>
                                            <th class="px-4 py-3">Jam buka</th>
                                            <th class="px-4 py-3">Jam tutup</th>
                                            <th class="px-4 py-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($course->presensi as $i => $item)
                                        <tr class="text-gray-700">
                                            <td class="px-4 py-3 border">{{$i+1}}</td>
                                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->topic}}
                                            </td>
                                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->open_date}}</td>
                                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->close_date}}
                                            </td>
                                            <td class="px-4 py-3 text-ms font-semibold border">
                                                <a href="{{route('presensi.show', $item)}}">Detail</a>
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
