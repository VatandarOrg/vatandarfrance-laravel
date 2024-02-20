<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ویرایش {{ __('Post') }}
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
                                <form method="POST" action="{{ route('admin.posts.update', $post->id) }}"
                                    class="space-y-3" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div>
                                        <x-label for="title" value="عنوان" />
                                        <x-input id="title" class="block mt-1 w-full" type="text" name="title"
                                            :value="$post->title" required autofocus autocomplete="title" />
                                        <x-input-error for="title" />
                                    </div>
                                    <div class="mt-4">
                                        <x-label for="description" value="توضیحات" />
                                        <x-textarea id="description" name="description">
                                            {{ $post->description }}</x-textarea>
                                        <x-input-error for="description" />
                                    </div>
                                    <div class="mt-4">
                                        <x-label for="section_id" value="سکشن" />
                                        <select
                                            class="border-gray-300 focus:border-stone-300 focus:ring focus:ring-stone-200 focus:ring-opacity-50 rounded-md shadow-sm w-full mt-1"
                                            name="section_id">
                                            <option value="">انتخاب کنید</option>
                                            @foreach ($sections as $item)
                                                <option value="{{ $item->id }}" @selected($post->section_id == $item->id)>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error for="section_id" />
                                    </div>
                                    <div class="mt-4">
                                        <x-label for="image" value="تصویر" />
                                        <x-input id="image" class="block mt-1 w-full" type="file" name="image"
                                            required autofocus autocomplete="image" accept="image/png, image/jpeg" />
                                        <img src="{{ $post->getFirstMediaUrl() }}" alt="" class="h-28">
                                        <x-input-error for="image" />
                                    </div>
                                    <div class="mt-4">
                                        <x-label for="web_view" value="web view" />
                                        <select
                                            class="border-gray-300 focus:border-stone-300 focus:ring focus:ring-stone-200 focus:ring-opacity-50 rounded-md shadow-sm w-full mt-1"
                                            name="web_view">
                                            <option value="">انتخاب کنید</option>
                                            <option value="1" @selected($post->web_view)>دارد</option>
                                            <option value="0" @selected(!$post->web_view)>ندارد</option>
                                        </select>
                                        <x-input-error for="web_view" />
                                    </div>
                                    <div class="mt-4">
                                        <x-label for="priority" value="اولویت" />
                                        <x-input id="priority" class="block mt-1 w-full" type="text" name="priority"
                                            :value="$post->priority" autofocus autocomplete="priority" />
                                        <x-input-error for="priority" />
                                    </div>
                                    <div class="mt-4">
                                        <x-label for="link" value="لینک" />
                                        <x-input id="link" class="block mt-1 w-full" type="text" name="link"
                                            :value="$post->link" autofocus autocomplete="link" />
                                        <x-input-error for="link" />
                                    </div>
                                    <div class="mt-4">
                                        <x-label for="lang" value="زبان" />
                                        <select
                                            class="border-gray-300 focus:border-stone-300 focus:ring focus:ring-stone-200 focus:ring-opacity-50 rounded-md shadow-sm w-full mt-1"
                                            name="lang">
                                            <option value="">انتخاب کنید</option>
                                            <option value="fa" @selected($post->lang == 'fa')>فارسی</option>
                                            <option value="fr" @selected($post->lang == 'fr')>فرانسوی</option>
                                        </select>
                                        <x-input-error for="lang" />
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
