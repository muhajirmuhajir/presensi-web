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
                    <div>
                        <x-label for="topic" :value="__('Mata Pelajaran')" />
                        <x-input id="topic" type="text" class="block mt-1 w-full" name="topic"
                            value="{{$presensi->fullname()}}" disabled />
                    </div>
                    <div class="mt-4">
                        <x-label for="topic" :value="__('Topik')" />
                        <x-input id="topic" type="text" class="block mt-1 w-full" name="topic"
                            value="{{$presensi->topic}}" disabled />
                    </div>
                    <div class="mt-4">
                        <x-label for="question" :value="__('Pertanyaan')" />
                        <x-textarea name="question" id="question" cols="5" class="block mt-1 w-full" disabled>
                            {{$presensi->question ?? "-"}}
                        </x-textarea>
                    </div>
                    <div class="mt-4">
                        <x-label for="open_date" :value="__('Jam Buka')" />

                        <x-input id="open_date" type="datetime-local" class="block mt-1 w-full" name="open_date"
                            value="{{ \Carbon\Carbon::parse($presensi->open_date)->format('Y-m-d\TH:i')}}" required
                            disabled />
                    </div>
                    <div class="mt-4">
                        <x-label for="close_date" :value="__('Jam Tutup')" />

                        <x-input id="close_date" type="datetime-local" class="block mt-1 w-full" name="close_date"
                            value="{{ \Carbon\Carbon::parse($presensi->close_date)->format('Y-m-d\TH:i')}}" required
                            disabled />
                    </div>
                    @role(config('enums.roles.teacher'))
                    <div class="my-4 flex gap-4">
                        <x-button-link href="{{route('presensi.edit', $presensi)}}">Edit</x-button-link>
                        <form action="{{route('presensi.destroy', $presensi)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus Presensi?')" class="bg-none underline text-sm"
                                type="submit">Hapus</button>
                        </form>
                    </div>
                    @endrole
                    <hr>
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl mt-6">Daftar Siswa</h3>
                        @role(config('enums.roles.bk'))
                        @if (\Carbon\Carbon::parse($presensi->close_date)->isPast())
                        <x-button-link href="{{route('presensi.rekap',$presensi->id)}}">Download Rekap</x-button-link>
                        @endif
                        @endrole
                    </div>

                    <section class="container mx-auto py-12">
                        <div class="flex gap-10 mb-4 text-gray-600">
                            <p>Belum presensi : {{$presensi->records->where('status', 1)->count()}}</p>
                            <p>Hadir : {{$presensi->records->where('status', 2)->count()}}</p>
                            <p>Izin : {{$presensi->records->where('status', 3)->count()}}</p>
                            <p>Sakit : {{$presensi->records->where('status', 4)->count()}}</p>
                            <p>Alpa : {{$presensi->records->where('status', 5)->count()}}</p>
                        </div>
                        <div class="w-full mb-8 overflow-hidden rounded-sm shadow-lg">
                            <div class="w-full">
                                <table class="w-full">
                                    <thead>
                                        <tr
                                            class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-200 uppercase border-b border-gray-600">
                                            <th class="px-4 py-3">No</th>
                                            <th class="px-4 py-3">Nama Siswa</th>
                                            <th class="px-4 py-3">Status</th>
                                            <th class="px-4 py-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($presensi->records as $i => $item)
                                        <tr class="text-gray-700">
                                            <td class="px-4 py-3 border">{{$i+1}}</td>
                                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->student->name}}
                                            </td>
                                            <td class="px-4 py-3 text-ms font-semibold border">
                                                {{$item->statusPresensi()}}</td>
                                            <td class="px-4 py-3 text-sm border">
                                                <a href="{{route('presensi.record.show', [$presensi, $item])}}"
                                                    class="underline hover:text-blue-400 hover:cursor-pointer">Detail</a>
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
