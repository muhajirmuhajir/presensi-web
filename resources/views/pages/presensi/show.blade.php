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
                    <hr>
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl mt-6">Daftar Siswa</h3>
                        @role(config('enums.roles.bk'))
                        <x-button-link href="{{route('presensi.rekap',$presensi->id)}}">Download Rekap</x-button-link>
                        @endrole
                    </div>

                    <section class="container mx-auto py-12">
                        <div class="w-full mb-8 overflow-hidden rounded-sm shadow-lg">
                            <div class="w-full">
                                <table class="w-full">
                                    <thead>
                                        <tr
                                            class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-200 uppercase border-b border-gray-600">
                                            <th class="px-4 py-3">No</th>
                                            <th class="px-4 py-3">Nama Siswa</th>
                                            <th class="px-4 py-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($presensi->records as $i => $item)
                                        <tr class="text-gray-700">
                                            <td class="px-4 py-3 border">{{$i+1}}</td>
                                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->student->name}}
                                            </td>
                                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->status}}</td>
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
