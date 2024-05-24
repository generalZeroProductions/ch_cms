@php
    $tStyle = $column->styles['title'];
    $title = $column->title;
    $body = $column->body;
@endphp

<div>
    <div class={{ $tStyle }}> {{ $title }}</div>
    <br>
    <p style="font-size:24px">
        @php
            echo htmlspecialchars_decode($body);
        @endphp
    </p>
    <br>
</div>
