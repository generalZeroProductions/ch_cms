<form method="POST" action = "/update_nav_item">
    @csrf
    <div class="form-group" style = "margin:0px">
        <div class="row align-items-center"> 
            <input type="text" class="form-control nav-name col new_item_input" id="nav_title" name="nav_title">
            <img src="{{ asset('icons\link.svg') }}" class="col-auto">
            <select id="route_select" name="route" class="form-control col new_item_input">
                <!-- Add options here -->
            </select>
            <button type="submit" class="confirm-edit-nav col-auto">
                <img src="{{ asset('icons/add18.svg') }}">
            </button>
        </div>
    </div>
    <input type="hidden" id="nav_id" name="nav_id">
    <input type="hidden" id="page_name" name="page_name">
</form>
