<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <x-success-session-status :status="session('success')" />
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Nama')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{$user->name}}"
                                required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="phone_number" :value="__('No Handphone')" />

                            <x-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number"
                                value="{{$user->phone_number}}" required autofocus />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                value="{{$user->email}}" required disabled />
                        </div>

                        <!-- Password -->
                        {{-- <div class="mt-4">
                            <x-label for="password" :value="__('Password')" />

                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                                autocomplete="new-password" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                name="password_confirmation" required />
                        </div> --}}

                        <div class="flex items-center justify-between mt-4">
                            <a @click="open = ! open" href="#"
                                class="underline text-sm text-gray-600 hover:text-gray-900">Ubah Password</a>
                            <x-button class="ml-4">
                                {{ __('Update Profile') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="open" @click.away="open = false">
            <div class="flex items-center justify-center fixed left-0 bottom-0 w-full h-full bg-gray-100 ">
                <div class="bg-white rounded-lg w-1/2">
                    <div class="w-full p-4">
                        <div class="flex items-center w-full">
                            <div class="text-gray-900 font-medium text-lg">Ubah Password</div>
                            <svg class="ml-auto fill-current text-gray-700 w-6 h-6 cursor-pointer" @click="open=false"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                <path
                                    d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                            </svg>
                        </div>
                        <hr>
                        <div class="mt-4">
                            <form id="update_password" action="{{route('account.password')}}" method="POST">
                                @csrf
                                <div>
                                    <x-label for="current_password" :value="__('Password Lama')" />

                                    <x-input id="current_password" class="block mt-1 w-full" type="password"
                                        name="current_password" required autofocus />
                                </div>

                                <div class="mt-3">
                                    <x-label for="new_password" :value="__('Password Baru')" />

                                    <x-input id="new_password" class="block mt-1 w-full" type="password"
                                        name="new_password" required autofocus />
                                </div>
                                <div class="mt-3">
                                    <x-label for="new_password_confirmation" :value="__('Password Baru')" />

                                    <x-input id="new_password_confirmation" class="block mt-1 w-full" type="password"
                                        name="new_password_confirmation" required autofocus />
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="ml-auto mt-4">
                            <x-button @click="document.getElementById('update_password').submit();">
                                {{ __('Update Password') }}
                            </x-button>
                            <a href="#" @click="open=false"
                                class="ml-10 underline text-sm text-gray-600 hover:text-gray-900">
                                {{ __('Batalkan') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
