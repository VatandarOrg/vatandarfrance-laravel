<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ویرایش {{ __('User') }}
            </h2>
        </div>
        @include('partials.alert')
        @include('partials.validation-errors')
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0">
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <form method="POST" action="{{ route('admin.users.update', $user->id) }}"
                                    class="space-y-5">
                                    @csrf
                                    @method('put')
                                    <div>
                                        <x-label for="first_name" value="{{ __('first_name') }}" />
                                        <x-input id="first_name" class="block mt-1 w-full" type="text"
                                            name="first_name" :value="$user->first_name" required autofocus
                                            autocomplete="first_name" />
                                    </div>
                                    <div class="mt-4">
                                        <x-label for="last_name" value="{{ __('last_name') }}" />
                                        <x-input id="last_name" class="block mt-1 w-full" type="text"
                                            name="last_name" :value="$user->last_name" required autofocus
                                            autocomplete="last_name" />
                                    </div>

                                    <div class="mt-4">
                                        <x-label for="email" value="{{ __('Email') }}" />
                                        <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                            :value="$user->email" required />
                                    </div>
                                    <div class="mt-4">
                                        <x-label for="mobile" value="{{ __('mobile') }}" />
                                        <x-input id="mobile" class="block mt-1 w-full" type="text" name="mobile"
                                            :value="$user->mobile" />
                                    </div>
                                    {{-- <div class="mt-4">
                                        <x-label for="password" value="{{ __('Password') }}" />
                                        <x-input id="password" class="block mt-1 w-full" type="password"
                                            name="password" required autocomplete="new-password" />
                                    </div>

                                    <div class="mt-4">
                                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                        <x-input id="password_confirmation" class="block mt-1 w-full"
                                            type="password" name="password_confirmation" required
                                            autocomplete="new-password" />
                                    </div> --}}
                                    <div class="form-group mt-5">
                                        <label class="font-size-h6 font-weight-bolder text-dark">افزودن نقش به
                                            کاربر</label>
                                        <hr>
                                    </div>
                                    <div class="form-group">
                                        @forelse ($roles as $role)
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" name='roles[]' value="{{ $role->name }}"
                                                    class="custom-control-input" id="{{ 'role' . $role->id }}"
                                                    {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="{{ 'role' . $role->id }}">{{ __($role->name) }}</label>
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
                                                    id="{{ 'permission' . $permission->id }}"
                                                    {{ $user->hasPermissionTo($permission) ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="{{ 'permission' . $permission->id }}">{{ __($permission->name) }}</label>
                                            </div>
                                        @empty
                                            <p>
                                                هیچ دسترسی تعریف نشده است .
                                            </p>
                                        @endforelse
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <x-button class="mr-4">
                                            {{ __('Edit') }}
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
    </x-admin-layout>
