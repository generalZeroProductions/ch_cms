  <form method="POST" action = "/updatePageTitle">
  @csrf
      <div class = "row">
      <input type = "text" id="page_title" name = "page_title">
          <button type="submit" class = "btn btn-success">Confirm</button>
      </div>
      <input type = "hidden" id="page" name = "page">
  </form>
