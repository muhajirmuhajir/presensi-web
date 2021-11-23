<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelas Saya') }}
            </h2>
            @role(config('enums.roles.bk'))
            <form action="{{route('course.create')}}">
                <x-button>Buat Mata Pelajaran</x-button>
            </form>
            @endrole
        </div>
    </x-slot>


    <section class="container mx-auto md:max-w-6xl py-12">
        <div class="w-full mb-8 overflow-hidden rounded-sm shadow-lg">
            <div class="w-full">
                <table class="w-full">
                    <thead>
                        <tr
                            class="text-sm font-semibold tracking-wide text-left text-gray-900 bg-gray-200 uppercase border-b border-gray-600">
                            <th class="px-4 py-3">No</th>
                            @role(config('enums.roles.bk'))
                            <th class="px-4 py-3">Nama Guru</th>
                            @endrole
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3">Mata Pelajaran</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($data as $i => $item)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 border">{{$i+1}}</td>
                            @role(config('enums.roles.bk'))
                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->teacher_name}}</td>
                            @endrole
                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->kelas_name}}</td>
                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->course_name}}</td>
                            <td class="px-4 py-3 text-sm border">
                                <a href="{{route('course.show', $item->id)}}"
                                    class="underline hover:text-blue-400 hover:cursor-pointer">Detail</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
