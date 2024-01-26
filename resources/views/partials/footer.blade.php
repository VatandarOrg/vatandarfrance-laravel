<div class="d-flex bg-dark z-index-1">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-auto">
                <img src="{{ asset(theme()->getMediaUrlPath() . '/logos/icon-white.svg') }}" class="h-70px py-5"
                    alt="Caspian">
            </div>
            <div class="col-auto align-self-center">
                <div class="menu menu-lg-rounded menu-row menu-title-light fs-6 my-5 my-lg-0" id="#kt_header_menu"
                    data-kt-menu="true">
                    <div class="menu-item me-lg-1"><a class="menu-link py-3" href="{{ route('homePage') }}"
                            onclick="LoadingShowFunction()"><span class="menu-title mx-lg-2">{{ __('home') }}</span></a></div>
                    <div class="menu-item"><a class="menu-link py-3" href="{{ route('FAQPage') }}"
                            onclick="LoadingShowFunction()"><span class="menu-title mx-lg-2">{{ __('FAQ') }}</span></a>
                    </div>
                    <div class="menu-item"><a class="menu-link py-3" href="{{ route('termsPage') }}"
                            onclick="LoadingShowFunction()"><span class="menu-title mx-lg-2">
                                {{ __('Terms and Conditions') }}
                            </span></a></div>
                    <div class="menu-item"><a class="menu-link active py-3" href="{{ route('contactPage') }}"
                            onclick="LoadingShowFunction()"><span class="menu-title mx-lg-2"> {{ __('contact') }}
                            </span></a></div>
                </div>
            </div>
        </div>
    </div>
</div>
