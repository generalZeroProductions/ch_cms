  <form method="POST" action = "/update_page_title">
  @csrf
      <div class = "row">
      <input type = "text" id="page_title" name = "page_title">
          <button type="submit" class = "btn btn-success">Confirm</button>
      </div>
      <input type = "hidden" id="page_id" name = "page_id">
      <input type = "hidden" id="scroll_to" name="scroll_to">
  </form>
