<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Permission') }}
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
                                <form method="POST" action="{{ route('admin.permissions.update', $permission->id) }}"
                                    class="space-y-5">
                                    @csrf

                                    @method('put')

                                    <div>
                                        <x-label for="name" value="نام دسترسی" />
                                        <x-input id="name" class="block mt-1 w-full" type="text"
                                            name="name" :value="$permission->name" required autofocus autocomplete="name" />
                                    </div>

                                    <div class="mt-4">
                                        <x-label value="نقش‌های اعطا شده" />
                                        <div class="md:grid md:grid-cols-3 md:gap-6 mt-1">
                                            @forelse ($roles as $role)
                                                <div class="col-span-1 flex space-x-2 space-x-reverse">
                                                    <input type="checkbox"
                                                        class="rounded border-gray-300 text-slate-600 shadow-sm focus:border-slate-300 focus:ring focus:ring-slate-200 focus:ring-opacity-50"
                                                        name="roles[]" id="{{ 'role_' . $role->id }}"
                                                        value="{{ $role->id }}"
                                                        @if ($permission->roles->contains($role)) checked @endif>
                                                    <x-label value="{{ $role->name }}"
                                                        for="{{ 'role_' . $role->id }}" />
                                                </div>
                                            @empty
                                                <div
                                                    class="mt-1 bg-red-50 border-2 border-red-500 rounded py-2 px-3 text-red-500 font-semibold text-sm w-full">
                                                    موردی یافت نشد</div>
                                            @endforelse
                                        </div>
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
