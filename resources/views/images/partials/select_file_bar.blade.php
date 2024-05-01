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
<div class="d-flex flex-row mb-2">
    <div class="p-2 w-100 ">
        <select class="form-control" id="select">
         <option value="选择一个文件...">选择一个文件...</option> 
            @foreach ($imageNames as $imageName)
                <option value="{{ $imageName }}">{{ $imageName }}</option>
            @endforeach
        </select>
    </div>
    <div class="p-2 flex-shrink-1">
        <a href="#" id="close">
            <img src="{{ asset('icons/close.svg') }}" class = "edit_icon"></a>
    </div>
</div>

<style>
    .edit_icon {
        height: 28px;
    }
</style>
