@php
    use App\Models\Navigation;
    $subNavItems = [];
    $navData = $nav->data['items'];
    foreach ($navData as $itemId) {
        $nextItem = Navigation::findOrFail($itemId);
        if ($nextItem) {
            $subNavItems[] = $nextItem;
        }
    }
    $jLocation = json_encode($location);
$jNav = json_encode($nav);
$jSub = json_encode($subNavItems);
$jDrop = json_encode(['nav'=>$nav,'sub'=>$subNavItems]);
@endphp

<li class="nav-item dropdown" id = "{{ $nav->id }}_{{ $nav->title }}">
    <div class="d-flex justify-content-start mb-3">


        <div class="p-2 nav-item {{ $loop->first ? 'active' : '' }}">
         <a class="nav-link dropdown-toggle" href="#" id="{{$nav->title}}Dropdown"
                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                {{ $nav->title }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                @foreach ($subNavItems as $subNav)
                    <a class="dropdown-item" href="#">{{ $subNav->title }}</a>
                @endforeach
            </div>

        </div>

        <div class="p-2 ">
            <a href="#" 
             onClick="openMainModal('nav?editDropdown','{{$jDrop}}','{{$jLocation }}','model-md')">
                <img src={{ asset('icons/pen.svg') }} class="edit-nav-pen"></a>
        </div>


        <div class="p-2 ">
            <a href = "#" 
                onClick="openMainModal('removeItem','{{$jNav}}',null, '{{$jLocation}}',' model-sm')">
                <img src={{ asset('icons/trash.svg') }} class = "edit-nav-trash"></a>
        </div>

    </div>
</li>



<style>
    .p-2 {
        padding-right: 0 !important;
        padding-left: 0 !important;
    }

  .edit-nav-pen {
      height:20px;
      margin-right:4px;
      margin-top: 10px;
    }

    .edit-nav-trash {
         height:20px;
        margin-right: 18px;
        margin-top: 10px;
    }
</style>
