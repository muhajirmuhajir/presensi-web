<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Presensi Record') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg relative">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-validation-errors class="mb-4" :errors="$errors" />

                    <form action="{{route('presensi.record.update',[$presensi, $record])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-label for="name" :value="__('Nama Siswa')" />

                            <x-input id="name" type="text" class="block mt-1 w-full" name="name"
                                value="{{$record->student->name ?? '-'}}" required autofocus disabled />
                        </div>
                        <div class="mt-4">
                            <x-label for="status" :value="__('Status Presensi')" />
                            <x-select id="status" class="w-full" name="status" required>
                                @foreach ($presensi_status as $item)
                                @if ($item == $record->status)
                                <option selected value="{{$item}}">
                                    {{\App\Models\PresensiRecord::parseStatus($item) . ' (Current)'}}</option>
                                @else
                                <option value="{{$item}}">{{\App\Models\PresensiRecord::parseStatus($item) }}</option>
                                @endif
                                @endforeach
                            </x-select>
                        </div>
                        <div class="md:flex py-2 items-center">
                            <x-button>Simpan Presensi</x-button>
                            <a href="{{route('presensi.show', $presensi)}}"
                                class="ml-10 underline text-sm text-gray-600 hover:text-gray-900">
                                {{ __('Batalkan') }}
                            </a>
                        </div>

                    </form>
                </div>

                <div class="absolute bottom-5 right-5">
                    <form action="{{route('presensi.record.destroy',[$presensi, $record] )}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus Presensi Record?')"
                            class="underline text-sm text-gray-600 hover:text-gray-900" type="submit">Hapus
                            Presensi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
