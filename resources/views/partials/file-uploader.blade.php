@props(['name', 'value' => null, 'disabled' => false, 'required' => false, 'autofocus' => false, 'placeholder' => '', 'targetURL' => 'https://caspianiran.com/admin/files?client=mobile'])

<div>
    <x-label for="fileUpload" :value="$placeholder" />
    <div id="fileUpload" class="mt-1 faNum" dir="rtl" targetURL="https://caspianiran.com/admin/files?client=mobile"
        file_id="{{ $name }}">
    </div>
    <div id="uploaderProgess"></div>

    <input type="hidden" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
        required="{{ $required }}">
</div>
