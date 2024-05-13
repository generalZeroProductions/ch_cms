@php
    $articleId1 = 'article_1' . $row->id;
    $articleId2 = 'article_2' . $row->id; 
@endphp
<div class = "container-fluid">
   <div class = 'container'>
    <div class = 'row'>
        <div class="col-md-6" id = "{{ $articleId1 }}">
            @include('articles.partials.title_text', ['column' => $column1, 'row' => $row])
        </div>
        <div class="col-md-6" id = "{{ $articleId2 }}">
            @include('articles.partials.title_text', ['column' => $column2, 'row' => $row])
        </div>
    </div>
    </div>
</div>
</div>

