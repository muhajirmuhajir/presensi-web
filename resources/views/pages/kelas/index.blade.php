<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('List Kelas') }}
            </h2>
            <form action="{{route('kelas.create')}}">
                <x-button>Buat Kelas</x-button>
            </form>
        </div>
    </x-slot>


    <section class="container mx-auto py-12">
        <div class="w-full mb-8 overflow-hidden rounded-sm shadow-lg">
            <div class="w-full ">
                <table class="w-full">
                    <thead>
                        <tr
                            class="text-sm font-semibold tracking-wide text-left text-gray-900 bg-gray-200 uppercase border-b border-gray-600">
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3">Jumlah Mata Pelajaran</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($data as $i => $item)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 border">{{$i+1}}</td>
                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->name}}</td>
                            <td class="px-4 py-3 text-ms font-semibold border">{{$item->courses_count}}</td>
                            <td class="px-4 py-3 text-sm border">
                                <a href="{{route('kelas.show', $item->id)}}"
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
