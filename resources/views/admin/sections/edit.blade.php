<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ویرایش {{ __('Section') }}
            </h2>
        </div>
        @include('partials.alert')
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0">
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <form method="POST" action="{{ route('admin.sections.update', $section->id) }}"
                                    class="space-y-5">
                                    @csrf
                                    @method('put')
                                    <div>
                                        <x-label for="name" value="نام" />
                                        <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                            :value="$section->name" required autofocus autocomplete="name" />
                                        <x-input-error for="name" />
                                    </div>
                                    <div class="mt-4">
                                        <x-label for="priority" value="اولویت" />
                                        <x-input id="priority" class="block mt-1 w-full" type="text" name="priority"
                                            :value="$section->priority" autofocus autocomplete="priority" />
                                        <x-input-error for="priority" />
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
</x-app-layout>
