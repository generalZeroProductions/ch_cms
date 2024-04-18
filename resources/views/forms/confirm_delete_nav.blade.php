<form method="POST" action = "/delete_nav_item">
    @csrf
    <div class="form-group" style = "margin:20px">
        <div class="row align-items-center"> <!-- Ensure all columns are vertically aligned -->
            <input type="hidden" id="nav_id" name="nav_id" class="col-auto">
           <button type="submit" class="btn btn-danger col-auto" id="delete_btn">
    <!-- Button content goes here -->
</button>
        </div>
    </div>
</form>