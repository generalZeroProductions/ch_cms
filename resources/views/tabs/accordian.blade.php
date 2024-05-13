@php
    $idx = 0;
@endphp

<div class="accordion" id="accordionExample">
    @foreach ($tabs as $tab)
        <div class="card">
            <div class="card-header tab_colors" id="heading{{ $idx }}">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left tab_header_def" type="button" data-toggle="collapse"
                        data-target="#collapse{{ $idx }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                        aria-controls="collapse{{ $idx }}">
                        {{ $tab->title }} // {{ $tab->route }}
                    </button>
                </h2>
            </div>
            <div id="collapse{{ $idx }}" class="collapse {{ $loop->first ? 'show' : '' }}"
                aria-labelledby="heading{{ $idx }}" data-parent="#accordionExample">
                <div class="card-body" id="content_{{ $idx }}">
                    {!! $contents[$idx] !!}
                </div>
            </div>
        </div>
        @php
            $idx++;
        @endphp
    @endforeach
</div>





<style>
    .tab_header_def {
        color: #333 !important;
    }

    .tab_header_def:hover {
        text-decoration: none !important;
        /* Remove text decoration on hover */
        color: #333 !important;
        /* Reset text color on hover */
    }

    .tab_colors {
        background-color: #bdc3ca;
    }

    .tab_colors:hover {
        background-color: #5499e3;
    }
</style>
