<form method="POST" action = "/new_nav_item">
    @csrf
    <div class="form-group" style = "margin:20px">
        <div class="row align-items-center"> <!-- Ensure all columns are vertically aligned -->
            <input type="hidden" id="nav_id" name="nav_id" class="col-auto">
            <input type="text" class="form-control nav-name col" id="nav_title" name="nav_title" value = "New Item">
            <img src="{{ asset('icons\link.svg') }}" class="col-auto">
            <select id="route_select" name="route" class="form-control col">
                <!-- Add options here -->
            </select>
            <button type="submit" class="confirm-add-nav col-auto">
                <img src="{{ asset('icons/check.svg') }}">
            </button>
        </div>
    </div>
</form>