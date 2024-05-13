@php
use Illuminate\Support\Facades\Log;
Log::info('in one column');
    $articleId = 'article_' . $row->id;
@endphp
<div class = 'container-fluid'>
    <div class = 'container'>
        <div class = "row">
            <div class="col-md-12" id = "{{ $articleId }}">
                @include('articles.partials.title_text', ['column' => $column, 'row' => $row])
            </div>
        </div>
    </div>
</div>
