  <div class="row d-flex align-items-center" style="margin-top:4px; margin-right:10px">

      <form id="edit_nav" class = "row" style="margin-right:4px" >
          @csrf
          <div class="p-2 ">
              <input type="text" class="form-control link-name " id="edit_nav_title" name="title">
          </div>
          <div class="p-2 ">
              <img src="{{ asset('icons\link.svg') }}" class = "link-icon">
          </div>
          <div class="p-2 ">
              <select id="route_select" name="route" class="form-control link-name ">
                  <!-- Add options here -->
              </select>
          </div>

          <input type="hidden" id="item_id" name="item_id">
          <input type="hidden" id="key" name="key">
          <input type="hidden" value="edit_nav" name="form_name">

      </form>

      <div class="p-2 ">
          <button class="btn btn-primary button-with-image" id ="edit_nav_btn">
              <img src="{{ asset('icons\save.svg') }}" class = "save-icon">
          </button>
      </div>

  </div>
  <style>
      .form-group {
          padding-left: 0px;
          padding-right: 0px;
      }

      .button-with-image {
          display: flex;
          justify-content: center;
          align-items: center;
          padding: 6px 6px;
          border: none;
          cursor: pointer;

      }


      .link-icon {
          height: 18px;
          margin-right: 8px;
      }

      .save-icon {
          height: 18px;
      }

      .link-name {
          width: 124px !important;
          height: 34px !important;
          font-size: 12px;
          margin-right: 8px;
      }
  </style>
