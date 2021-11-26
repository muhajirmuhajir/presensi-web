<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mata Pelajaran Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('course.update', $course)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-label for="name" :value="__('Nama Mata Pelajaran')" />

                            <x-input id="name" type="text" class="block mt-1 w-full" name="name"
                                value="{{$course->name}}" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-label for="kelas_id" :value="__('Kelas')" />
                            <x-select name="kelas_id" id="kelas_id" class="block mt-1 w-full" required autofocus>
                                @foreach ($kelas as $item)
                                @if ($course->kelas_id == $item->id)
                                <option selected value="{{$item->id}}">{{$item->name . ' (Default)'}}</option>
                                @else
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endif
                                @endforeach
                            </x-select>
                        </div>
                        <div class="mt-4">
                            <x-label for="teacher_id" :value="__('Guru')" />
                            <x-select name="teacher_id" id="teacher_id" class="block mt-1 w-full" required autofocus>
                                @foreach ($teachers as $item)
                                @if ($course->teacher_id == $item->id)
                                <option selected value="{{$item->id}}">{{$item->name . ' (Current)'}}</option>
                                @else
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endif
                                @endforeach
                            </x-select>
                        </div>

                        <div class="mt-4">
                            <x-button>Update Mata Pelajaran</x-button>
                            <a href="{{route('course.show', $course)}}"
                                class="ml-10 underline text-sm text-gray-600 hover:text-gray-900">
                                {{ __('Batalkan') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
