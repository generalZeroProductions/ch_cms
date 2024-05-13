    @php
    use Illuminate\Support\Facades\Log;

        $title = $column->title;
        $body = $column->body;
        $divId = 'article_' . $row->id;
        $jColumn = json_encode(['rowId'=>$row->id,'article'=>$column]);
    @endphp
    <div>
        @if ($editMode && !$tabContent)
            <div class="d-flex align-items-center icon-space">
                <a style= "cursor: pointer;" onClick = "insertForm('edit_title_text','{{ $jColumn }}',  '{{ $divId }}')">
                    <span><img src="{{ asset('icons/pen.svg') }}" class="pen-icon"></span>
                </a>
            </div>
        @endif
        <div style="width:100%" id="{{$divId}}">
            <div> {!! $title !!}</div>

            <div> {!! $body !!}</div>

        </div>
    </div>



    <style>
        .pen-icon {
            margin-left: 10px;
            height: 18px
        }

        .icon-space {
            height: 48px;
        }
    </style>
