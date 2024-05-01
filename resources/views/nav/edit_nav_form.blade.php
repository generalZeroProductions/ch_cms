<form method="POST" action = "/update_nav_item">
    @csrf
    <div class="form-group" style= >
        <div class="row d-flex justify-content-between mb-3">
            <div class="p-2 ">
                <input type="text" class="form-control" id="nav_title" name="nav_title">
            </div>
            <div class="p-2 ">
                <img src="{{ asset('icons\link.svg') }}">
            </div>
            <div class="p-2 ">
                <select id="route_select" name="route" class="form-control ">
                    <!-- Add options here -->
                </select>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-end mb-3" style="padding-right:20px">
        <button type="submit" class="btn-primary">
            更改导航项
        </button>
    </div>
    <input type="hidden" id="nav_id" name="nav_id">
    <input type="hidden" id="page_id" name="page_id">
    <input type="hidden" id="scroll_to" name="scroll_to">
</form>

<style>
.form-group{
    padding-left:20px;
    padding-right:20px;
}
    .link-icon {
        margin-right: 10px;
        margin-left: 10px;
    }
</style>