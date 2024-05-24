
 <form method="POST" action="/delete_contact">
    @csrf
    <div class="form-group" style = "margin:0px">
        <div class="row justify-content-center">
           <input type="hidden" name = "scrollDash" id="scrollDash">
        <input type = "hidden" name = "inq_id" id="inq_id">

        <button class="btn btn-danger col-auto" id="delete_contact_btn">
            删除
        </button>
        </div>
    </div>

</form>