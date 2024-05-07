<form method="POST" action = "/write_" id="nav_standard">
    @csrf
    <div class="form-group" style= "margin-right:18px">
        <div class="row d-flex  mb-3">
            <div class="p-2 ">
                <input type="text" class="form-control link-name " id="title" name="title">
            </div>
            <div class="p-2 ">
                <img src="{{ asset('icons\link.svg') }}" class = "link-icon">
            </div>
            <div class="p-2 ">
                <select id="route_select" name="route" class="form-control link-name ">
                    <!-- Add options here -->
                </select>
            </div>
            <div class="p-2 ">
                <button type="submit" class="btn btn-primary button-with-image">
                    <img src="{{ asset('icons\save.svg') }}" class = "save-icon">
                </button>
            </div>
        </div>
    </div>

    <input type="hidden" id="item_id" name="item_id">
    <input type="hidden" value="nav_standard" name="form_name">

</form>

<style>
    .form-group {
        padding-left: 0px;
        padding-right: 0px;
    }
   .button-with-image {
    display: flex;
    justify-content: center; /* Align content horizontally to center */
    align-items: center; /* Align content vertically to center */
    padding: 10px 20px; /* Adjust padding as needed */
    border: none; /* Remove default button border */
    background-color: #e0e0e0; /* Add background color */
    cursor: pointer; /* Show pointer cursor on hover */
}

.button-with-image img {
    display: block; /* Ensure the image is a block element */
    max-width: 100%; /* Ensure the image doesn't exceed the button width */
    height: auto; /* Maintain aspect ratio */
}

    .link-icon {
        height:24px;
        margin-right: 8px;
       
    }
     .save-icon {
       height:24px;
    }

    .link-name {
        width: 124px !important;
         margin-right: 8px;
    }
</style>
