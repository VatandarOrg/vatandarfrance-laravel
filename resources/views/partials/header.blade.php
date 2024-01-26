<div class="d-flex align-items-stretch justify-content-between">
    <!--begin::Header-->
    <div id="kt_header" class="header bg-white shadow-sm w-100 align-items-stretch" {{ theme()->
        printHtmlAttributes('header') }}>
        <!--begin::Container-->
        <div class="container align-self-center">
            <div class="d-flex align-items-center justify-content-between">
                <!--begin::Logo-->
                <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
                    <a href="{{ route('homePage') }}" onclick="LoadingShowFunction()" class="d-flex">
                        <img alt="Logo" src="{{ asset(theme()->getMediaUrlPath() . 'logos/VV.png') }}" class="h-30px" />
                        <div class="ms-3 d-inline-flex flex-column justify-content-center align-items-center">
                            <img alt="LogoText" src="{{ asset('demo1/media/logos/text-dark.svg') }}"
                                class="h-15px logo">
                        </div>
                    </a>
                </div>
                <!--end::Logo-->

                <!--begin::Wrapper-->
                <div class="d-lg-block">
                    <!--begin::Navbar-->
                    @if(theme()->getOption('layout', 'header/left') === 'menu')
                    <div class="d-flex align-items-stretch" id="kt_header_nav">

                        <span
                            class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5 d-none"
                            data-kt-search-element="clear">
                            <?php echo theme()->getSvgIcon("icons/duotone/Navigation/Close.svg", "svg-icon-2 svg-icon-lg-1 svg-icon-white position-absolute top-50 translate-middle-y")?>
                            <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                        </span>

                        {{ theme()->getView('layout/header/_menu') }}
                    </div>
                    @endif
                    <!--end::Navbar-->
                </div>
                <!--end::Wrapper-->

                {{--begin::Header menu toggle--}}
                @auth

                <div class="btn bg-light bg-opacity-75 ms-auto p-0 border align-content-center justify-content-center align-items-center btn-lg d-flex">
                    <div class="d-flex align-items-center p-1 pe-3"
                        id="kt_header_user_menu_toggle" data-kt-menu-trigger="click"
                        data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"
                        data-kt-menu-flip="bottom">
                        {{--begin::Menu--}}
                        <div class="cursor-pointer symbol symbol-35px">
                            <img src="{{ auth()->user()->photo_url }}" alt="metronic" />
                        </div>
                        <p class="ms-2 my-auto">سلام <span class="fw-boldest">{{ auth()->user()->first_name }}</span></p>
                        {{--end::Menu--}}
                    </div>
                    {{ theme()->getView('partials/topbar/_user-menu') }}
                </div>
                <div class="d-flex align-items-center ms-2">
                    {{--begin::Menu--}}
                    <a href="{{route('dashboard.chat.index')}}" class="btn btn-icon btn-light-primary btn-lg" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                        {!! theme()->getSvgIcon("icons/duotone/Communication/Group-chat.svg","svg-icon-1 svg-icon-2x") !!}
                    </a>
                </div>

                @if(theme()->getOption('layout', 'header/left') === 'menu')
                <div class="d-flex align-items-center ms-2 me-3">
                    <div class="btn btn-icon btn-light-primary btn-lg" id="kt_header_menu_mobile_toggle">
                        {!! theme()->getSvgIcon("icons/duotone/Text/Menu.svg", "svg-icon-1 svg-icon-2x")
                        !!}
                    </div>
                </div>
                @endif

                @endauth
                {{--end::Header menu toggle--}}
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Header-->
</div>
