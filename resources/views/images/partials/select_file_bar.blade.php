@php
    use Illuminate\Support\Facades\Storage;
    
    
    $directory = 'public/images'; // Adjust the directory path as per your setup
    $files = Storage::allFiles($directory);
    
    $imageNames = [];
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $imageNames[] = pathinfo($file, PATHINFO_BASENAME);
        }
    }   
@endphp
<div class="d-flex bd-highlight">
    <div class="p-2 w-100 bd-highlight">
        <select class="form-control" id="select">
            @foreach ($imageNames as $imageName)
                <option value="{{ $imageName }}">{{ $imageName }}</option>
            @endforeach
        </select>
    </div>
    <div class="p-2 flex-shrink-1 bd-highlight">
        <a href="#" id="close">
            <img src="{{ asset('icons/close.svg') }}" class = "edit_icon"></a>
    </div>
</div>

<style>
    .edit_icon {
        height: 25px;
        margin: 10px
    }
</style>
