<x-app-layout>
    <!--begin::Container-->
    <div id="kt_content_container" class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">
                <div>
                    @include('partials.alert')
                    @include('partials.validation-errors')

                </div>
                <div class="card card-custom gutter-b ">
                    <!--begin::Header-->
                    <div class="card-header py-5">
                        <h3 class="card-title">{{ __('آپلود فایل') }}</h3>

                        <div class="card-toolbar">
                            <a href="{{ route('admin.files.index') }}"
                                class="btn btn-primary">
                                <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen059.svg-->
                                <span class="svg-icon svg-icon-muted svg-icon-1"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15"
                                        fill="none">
                                        <rect y="6" width="16" height="3" rx="1.5" fill="black" />
                                        <rect opacity="0.3" y="12" width="8" height="3" rx="1.5" fill="black" />
                                        <rect opacity="0.3" width="12" height="3" rx="1.5" fill="black" />
                                    </svg></span>
                                <!--end::Svg Icon-->
                                {{ __('لیست فایل ها') }}
                            </a>
                        </div>
                    </div>
                    <!--end::Header-->
                    <div class="card-body">
                        <form action="{{ route('admin.files.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="dropzone dropzone-default" id="dropzone">
                                        <div class="dropzone-msg dz-message needsclick">
                                            <h3 class="dropzone-msg-title">فایل را اینجا بکشید و یا روی این باکس کلیک کنید
                                            </h3>
                                            <span class="dropzone-msg-desc">فرمت‌های قابل قبول: JPEG | JPG | PNG | PDF | GIF | MP3 | MP4 |‌ حداکثر
                                                حجم 10MB</span>
                                        </div>
                                    </div>
                                    <small class="form-text text-danger">
                                        {{ $errors->first('photo_id') }} </small>
                                </div>
                            </div>
                            <input type="hidden" name="photo_id" id="photo_id" value="{{ old('photo_id') }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Container-->
    @section('scripts')
        <script type="text/javascript" defer>
            $(document).ready(function() {
                $('#dropzone').dropzone({
                    url: "{{ route('admin.files.store') }}", // Set the url for your upload script location
                    paramName: "file", // The name that will be used to transfer the file
                    // maxFiles: 1,
                    maxFilesize: 10, // MB
                    // addRemoveLinks: true,
                    acceptedFiles: ".jpeg,.jpg,.png,.pdf,.gif,.mp3,.mp4",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    init: function() {
                        this.on("success", function(response) {
                            // console.log(response);
                        });
                    },
                    success: function(file, response) {
                        $("#photo_id").val(response);
                    }
                });
            });
        </script>
    @endsection
</x-admin-layout>
