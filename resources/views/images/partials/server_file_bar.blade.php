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

<div id="server_file_bar">
    <select class= "form-control file-select-bar" id="server" name = "server_file">
        <option value="选择一个文件...">选择一个文件...</option>
        @foreach ($imageNames as $imageName)
            <option value="{{ $imageName }}">{{ $imageName }}</option>
        @endforeach
    </select>
    </select>
</div>
