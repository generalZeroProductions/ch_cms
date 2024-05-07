@php
    use Illuminate\Support\Facades\Session;
    use App\Models\Navigation;
    use App\Models\ContentItem;
    use Illuminate\Support\Facades\Storage;
    $name =' none ';
    if (isset($page)) {
        $local = ContentItem::where('type', 'page')->where('title', $page)->first();
        $name = $local->title;
    }
@endphp

<div class="red-center">
    <p>无法在选项卡内显示选项卡式内容。{{$name}}</p>
    <button id="new_fetch" onClick="contentChange('{{$name}}')"> button</button>
</div>

<style>
    .red-center {
        background-color: lightcoral;
        margin: 0;
        height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, sans-serif;
        font-size: 34px;
        font-weight: 500;
        color: white;
    }
</style>
