@php
    $idx = 0;
@endphp

{{-- <div class="accordion" id="accordionExample">
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
</div> --}}

<div class="accordion" id="accordionExample">
    @foreach ($tabs as $key => $tab)
        <div class="card">
            <div class="card-header tab_colors" id="heading{{ $key }}">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left tab_header_def" type="button" data-toggle="collapse"
                        data-target="#collapse{{ $key }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                        aria-controls="collapse{{ $key }}">
                        {{ $tab->title }}
                    </button>
                </h2>
            </div>
            <div id="collapse{{ $key }}" class="collapse {{ $loop->first ? 'show' : '' }}"
                aria-labelledby="heading{{ $key }}" data-parent="#accordionExample">
                <div class="card-body" id="content_{{ $key }}">
                    {!! $contents[$key] !!}
                </div>
            </div>
        </div>
    @endforeach
</div>




<style>
    .tab_header_def {
        color: white !important;
        font-weight: bold;
        font-size:30px;
    }

    .tab_header_def:hover {
        text-decoration: none !important;
        /* Remove text decoration on hover */
        color: white !important;
        /* Reset text color on hover */
    }

    .tab_colors {
        background-color: rgb(148, 149, 154);
    }

    .tab_colors:hover {
        background-color: rgb(174, 176, 181);
    }
</style>
