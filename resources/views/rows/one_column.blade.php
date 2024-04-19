@php
    use App\Models\ContentItem;
    $data = $row->data;
    $columnData = $data['columns'];
   
    $column = ContentItem::findOrFail($columnData[0]);
   
    $articleId = "article_".$column->id;
   
    $editMode = true;
@endphp
    <div class="row space-row">
        <div class="col-md-12" id = "{{$articleId}}">
            @include('rows/title_text',['column'=> $column, 'page'=>$page])
        </div>
    </div>
