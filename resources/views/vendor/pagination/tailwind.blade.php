@if ($paginator->hasPages())
    <div class="flex justify-center mt-6">
        <div class="flex space-x-1">
            {{-- Tombol "Prev" --}}
            @if ($paginator->onFirstPage())
                <button class="rounded-full border border-slate-300 py-2 px-3 text-sm shadow-sm text-slate-400 cursor-not-allowed disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2" disabled>
                    Prev
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}">
                    <button class="rounded-full border border-slate-300 py-2 px-3 text-sm shadow-sm text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:bg-slate-800 active:text-white ml-2">
                        Prev
                    </button>
                </a>
            @endif

            {{-- Tombol halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="min-w-9 rounded-full border border-slate-300 py-2 px-3.5 text-sm shadow-sm text-slate-400 ml-2">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="min-w-9 rounded-full bg-slate-800 py-2 px-3.5 border border-transparent text-sm text-white shadow-md ml-2" aria-current="page">
                                {{ $page }}
                            </button>
                        @else
                            <a href="{{ $url }}">
                                <button class="min-w-9 rounded-full border border-slate-300 py-2 px-3.5 text-sm shadow-sm text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:bg-slate-800 active:text-white ml-2">
                                    {{ $page }}
                                </button>
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol "Next" --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}">
                    <button class="rounded-full border border-slate-300 py-2 px-3 text-sm shadow-sm text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:bg-slate-800 active:text-white ml-2">
                        Next
                    </button>
                </a>
            @else
                <button class="rounded-full border border-slate-300 py-2 px-3 text-sm shadow-sm text-slate-400 cursor-not-allowed disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2" disabled>
                    Next
                </button>
            @endif
        </div>
    </div>
@endif
