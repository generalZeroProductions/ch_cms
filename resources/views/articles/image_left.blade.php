@php
    $articleId = 'article_' . $row->id;
    $imageId = 'image_' . $row->id;
@endphp

<div class="d-flex justify-content-start">
    <div class="col-3 d-flex align-items-start image-column">
        @include('articles.partials.image_column', [
            'column' => $column2,
            'row' => $row,
        ])

    </div>
    <div class="col-9 d-flex align-items-start article-column" id = "{{ $articleId }}">
        @include('articles.partials.title_text', [
            'column' => $column1,
            'row' => $row,
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
