<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permissions') }}
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
                        <h3 class="text-lg font-semibold leading-6 text-gray-900">افزودن دسترسی</h3>
                        <p class="mt-1 text-sm text-gray-600">ساخت دسترسی و اعطای آن‌ها به نقش‌های ساخته شده در سایت از
                            این بخش انجام می‌شود.</p>
                    </div>
                </div>
                <div class="mt-5 md:col-span-2 md:mt-0">
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <form method="POST" action="{{ route('admin.permissions.store') }}">
                                        @csrf

                                        <div>
                                            <x-label for="name" value="نام دسترسی" />
                                            <x-input id="name" class="block mt-1 w-full" type="text"
                                                name="name" :value="old('name')" required autofocus
                                                autocomplete="name" />
                                        </div>

                                        <div class="mt-4">
                                            <x-label value="نقش‌ها" />
                                            <div class="md:grid md:grid-cols-3 md:gap-6 mt-1">
                                                @forelse ($roles as $role)
                                                    <div class="col-span-1 flex space-x-2 space-x-reverse">
                                                        <x-checkbox name="roles[]" id="{{ 'role_' . $role->id }}"
                                                            value="{{ $role->id }}" type="checkbox" />
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

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="px-4 sm:px-0 mb-5">
                <h3 class="text-lg font-semibold leading-6 text-gray-900">لیست دسترسی‌ها</h3>
            </div>

            <table class="w-full min-w-full divide-y divide-gray-300 shadow-md overflow-hidden sm:rounded-lg border bg-white mb-3">
                <thead class="bg-gray-50 sm:rounded-t-lg relative">
                    <tr class="relative">
                        <th scope="col" class="text-right font-bold text-sm py-2 px-5">شناسه</th>
                        <th scope="col" class="text-right font-bold text-sm py-2 px-2">نام دسترسی</th>
                        <th scope="col" class="text-right font-bold text-sm py-2 px-2">نقش‌های دارای دسترسی</th>
                        <th scope="col" class="text-right font-bold text-sm py-2 px-2">عملیات </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($permissions as $permission)
                        <tr>
                            <td class="font-medium text-sm py-4 px-5">{{ $permission->id }}</td>
                            <td class="font-medium text-sm py-4 px-2">{{ __($permission->name) }}</td>
                            <td class="font-medium text-sm py-4 px-2">
                                @foreach ($permission->roles as $role)
                                    <div>{{ __($role->name) }}</div>
                                @endforeach
                            </td>
                            <td class="font-medium text-sm py-4 px-2">
                                <div class="flex space-x-2 space-x-reverse">
                                    <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                        class="flex items-center content-center justify-center text-yellow-500 bg-yellow-100 h-7 w-7 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-4 h-4">
                                            <path
                                                d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                        </svg>
                                    </a>

                                    <div x-data="{ open: false }">
                                        <button @click="open = true"
                                            class="flex items-center content-center justify-center text-red-500 bg-red-100 h-7 w-7 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div @keydown.window.escape="open = false" x-show="open" x-cloak
                                            class="fixed inset-0 overflow-y-auto" aria-labelledby="modal-title"
                                            x-ref="dialog" aria-modal="true">
                                            <div
                                                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                                <div x-show="open" x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0"
                                                    x-transition:enter-end="opacity-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0"
                                                    x-description="Background overlay, show/hide based on modal state."
                                                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                                    @click="open = false" aria-hidden="true">
                                                </div>

                                                <!-- This element is to trick the browser into centering the modal contents. -->
                                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                                    aria-hidden="true">​</span>

                                                <div x-show="open" x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    x-description="Modal panel, show/hide based on modal state."
                                                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                        <div class="sm:flex sm:items-start">
                                                            <div
                                                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                <svg class="h-6 w-6 text-red-600"
                                                                    x-description="Heroicon name: outline/exclamation"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    aria-hidden="true">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                            <div
                                                                class="mt-3 text-center sm:mt-0 sm:mr-4 sm:text-right">
                                                                <h3 class="text-lg leading-6 font-bold text-gray-900">
                                                                    حذف دسترسی
                                                                </h3>
                                                                <div class="mt-2">
                                                                    <p class="text-sm leading-6 text-gray-500">
                                                                        آیا از حذف این دسترسی مطمئن هستید؟
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                        <form
                                                            action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                                                                @click="open = false">
                                                                حذف
                                                            </button>
                                                        </form>
                                                        <button type="button"
                                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                                            @click="open = false">
                                                            انصراف
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border sm:rounded-b-lg">
                            <td class="py-3 px-3 font-semibold text-sm text-center" colspan="4">
                                <div
                                    class="w-10 h-10 bg-gray-100 flex items-center justify-center rounded-full mx-auto mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <span>
                                    موردی یافت نشد
                                </span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $permissions->links('vendor.pagination.tailwind') }}
        </div>
</x-admin-layout>
