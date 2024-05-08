@php
    $articleId1 = 'article_' . $column1->id;
    $articleId2 = 'article_' . $column2->id; 
@endphp
<div class = "container-fluid">
   <div class = 'container'>
    <div class = 'row'>
        <div class="col-md-6" id = "{{ $articleId1 }}">
            @include('app.layouts.partials.title_text', ['column' => $column1, 'location' => $location])
        </div>
        <div class="col-md-6" id = "{{ $articleId2 }}">
            @include('app.layouts.partials.title_text', ['column' => $column2, 'location' => $location])
        </div>
    </div>
    </div>
</div>
</div>

