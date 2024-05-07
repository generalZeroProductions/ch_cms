@php
$authState = "off";
if(Auth::check())
{
$authState = 'on';
}
@endphp

<div class="d-flex justify-content-start">
    <div class="p-2 bd-highlight">
        <form method="post" action="/admin/on">
            @csrf <!-- Add CSRF protection -->
            <button type="submit">On</button>
        </form>
    </div>
    <div class="p-2 bd-highlight">
        <form method="post" action="/admin/off">
            @csrf <!-- Add CSRF protection -->
            <button type="submit">Off</button>
        </form>
    </div>
    <div class="p-2 bd-highlight">
        <h6> {{ $authState }}</h6>
    </div>
</div>


