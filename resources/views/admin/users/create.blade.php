<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                افرودن {{ __('User') }}
            </h2>
        </div>
        @include('partials.alert')
        @include('partials.validation-errors')
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900">افزودن {{ __('User') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">ساخت {{ __('users') }}‌در سایت از
                            این بخش انجام می‌شود.</p>
                    </div>
                </div>
                <div class="mt-5 md:col-span-2 md:mt-0">
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <form method="POST" action="{{ route('admin.users.store') }}">
                                        @csrf
                                        <div>
                                            <x-label for="first_name" value="{{ __('first_name') }}" />
                                            <x-input id="first_name" class="block mt-1 w-full" type="text"
                                                name="first_name" :value="old('first_name')" required autofocus
                                                autocomplete="first_name" />
                                        </div>
                                        <div class="mt-4">
                                            <x-label for="last_name" value="{{ __('last_name') }}" />
                                            <x-input id="last_name" class="block mt-1 w-full" type="text"
                                                name="last_name" :value="old('last_name')" required autofocus
                                                autocomplete="last_name" />
                                        </div>
                                        <div class="mt-4">
                                            <x-label for="email" value="{{ __('Email') }}" />
                                            <x-input id="email" class="block mt-1 w-full" type="email"
                                                name="email" :value="old('email')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-label for="mobile" value="{{ __('Mobile') }}" />
                                            <x-input id="mobile" class="block mt-1 w-full" type="text"
                                                name="mobile" :value="old('mobile')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-label for="password" value="{{ __('Password') }}" />
                                            <x-input id="password" class="block mt-1 w-full" type="password"
                                                name="password" required autocomplete="new-password" />
                                        </div>

                                        <div class="mt-4">
                                            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                            <x-input id="password_confirmation" class="block mt-1 w-full"
                                                type="password" name="password_confirmation" required
                                                autocomplete="new-password" />
                                        </div>
                                        <div class="form-group mt-5">
                                            <label class="font-size-h6 font-weight-bolder text-dark">افزودن نقش به
                                                کاربر</label>
                                            <hr>
                                        </div>
                                        <div class="form-group">
                                            @forelse ($roles as $role)
                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                    <input type="checkbox" name='roles[]' value="{{ $role->name }}"
                                                        class="custom-control-input" id="{{ 'role' . $role->id }}">
                                                    <label class="custom-control-label"
                                                        for="{{ 'role' . $role->id }}">{{ $role->name }}</label>
                                                </div>

                                            @empty
                                                <p>
                                                    هیچ نقشی تعریف نشده است.
                                                </p>
                                            @endforelse
                                        </div>
                                        <div class="form-group mt-5">
                                            <label class="font-size-h6 font-weight-bolder text-dark">افزودن دسترسی به
                                                کاربر</label>
                                            <hr>
                                        </div>
                                        <div class="form-group">
                                            @forelse ($permissions as $permission)
                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                    <input type="checkbox" name='permissions[]'
                                                        value="{{ $permission->name }}" class="custom-control-input"
                                                        id="{{ 'permission' . $permission->id }}">
                                                    <label class="custom-control-label"
                                                        for="{{ 'permission' . $permission->id }}">{{ $permission->name }}</label>
                                                </div>
                                            @empty
                                                <p>
                                                    هیچ دسترسی تعریف نشده است .
                                                </p>
                                            @endforelse
                                        </div>
                                        <div class="flex items-center justify-end mt-4">
                                            <x-button class="mr-4">
                                                {{ __('Submit') }}
                                            </x-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </x-admin-layout>
