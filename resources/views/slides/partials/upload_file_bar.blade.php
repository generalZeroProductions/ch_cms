<div class="d-flex flex-row mb-2">
    <form enctype="multipart/form-data" method="POST"> @csrf
        <input type="file" class="form-control-file" name=uploaded_image>
        <input type = "hidden" name="form_name" value="slide_img_upload">
    </form>
    <a href="#" id="close">
        <img src="{{ asset('icons/close.svg') }}" class = "edit_icon"></a>

</div>
<style>
    .edit_icon {
        height: 28px;
    }
</style>
