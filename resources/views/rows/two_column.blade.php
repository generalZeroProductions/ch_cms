@php
    use App\Models\ContentItem;
    $data = $row->data;
    $columnData = $data['columns'];
   
    $column1 = ContentItem::findOrFail($columnData[0]);
    $column2 = ContentItem::findOrFail($columnData[1]);
    $articleId1 = "article_".$column1->id;
    $articleId2 = "article_".$column2->id;
    $editMode = true;
@endphp
    <div class="row space-row">
        <div class="col-md-6" id = "{{$articleId1}}">
            @include('rows/title_text',['column'=> $column1, 'page'=>$page])
        </div>
        <div class="col-md-6" id = "{{$articleId2}}">
            @include('rows/title_text',['column'=> $column2, 'page'=>$page])
        </div>
    </div>
