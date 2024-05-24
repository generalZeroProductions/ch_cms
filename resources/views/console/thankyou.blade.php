@php
    Log::info('inTHANKYOU');
    $tStyle = $thanks->styles['title'];
    $title = $thanks->title;
    $body = $thanks->body;
   
@endphp

<div style="height:190px"></div>
<div class = "container" style="text-align:center">

    <div class={{ $tStyle }}> {{ $title }}</div>
    <br>
    <p style="font-size:24px">
        {{ $body }}
    </p>
</div>
<br>
</div>
<div style="height:190px"></div>
