@php
$linkId = $location['page']['title'].'_'.$location['page']['id'];
@endphp

@if ($editMode)
        <div class = 'parent'>
            <div class="child" id = "{{ $linkId }}">
                <p class = "title_indicator"> 页面名称:</p>
                <p class = "title_reference">{{ $location['page']['title'] }}</p>
                <a href="#"
                    onClick = "changePageTitle('{{ json_encode($location) }}','{{ $linkId }}')">
                    <img src="{{ asset('icons/pen.svg') }}" style = "margin-bottom: 4px; margin-left:8px">
                </a>
            </div>
        </div>
@endif
