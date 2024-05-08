@php

    $articleId = 'article_' . $column1->id;
    $imageId = 'image_' . $column2->id;
   
@endphp

<div class="d-flex justify-content-start"> 
    <div class="col-9 d-flex align-items-start article-column" id = "{{ $articleId }}">
        @include('app/layouts/partials/title_text', [
            'column' => $column1,
            'location' => $location,
        ])
    </div>
    <div class="col-3 d-flex align-items-start image-column" id = "{{ $imageId }}">
        @include('app/layouts/partials/image_column', [
            'column' => $column2,
            'location' => $location,
        ])

    </div>
</div>

<style>
    .space-top-40 {
        background-color: orange;
        height: 40px;
    }

    .image-column {

        width: 100%;
    }

    .article-column {
        padding-left: 5%;
        padding-right: 5%;
    }
</style>