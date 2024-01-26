{{-- @if ($paginator->hasPages())
    <div class="text-center py-2 mt-10">
        <a href="{{ $paginator->previousPageUrl() }}"
            class="btn btn-icon btn-sm btn-light mr-2 my-1 {{ $paginator->onFirstPage() ? ' disabled' : '' }}"><i
                class="ki ki-bold-arrow-next icon-xs"></i></a>

        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <a href="{{ $paginator->url($i) }}"
                class="btn btn-icon btn-sm border-0 btn-light mr-2 my-1 {{ $paginator->currentPage() == $i ? ' btn-hover-primary active' : '' }}">{{ $i }}</a>
        @endfor
        <a href="{{ $paginator->nextPageUrl() }}"
            class="btn btn-icon btn-sm btn-light mr-2 my-1 {{ $paginator->hasMorePages() ? ' ' : 'disabled' }}"><i
                class="ki ki-bold-arrow-back icon-xs"></i></a>

    </div>
@endif --}}

@if ($paginator->hasPages())
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
            </li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled">{{ $element }}</li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <a class="page-link">{{ $page }}</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link" href="#">Next</a>
            </li>
        @endif
    </ul>
@endif
