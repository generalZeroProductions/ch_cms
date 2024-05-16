  <div class="d-flex flex-column">
      <form id = "edit_text_article">
          @csrf
          <div class="form-group">
              <div class="p-2 ">
                  <h5>文章标题</h5>
              </div>
              <div class= "row flex-d">
                  <div class = "col-9">
                      <input type="text" class="form-control t1" id="edit_text_article_title" name="title">
                  </div>
                  <div class = "col-3">
                      <select class= "form-control" id="size_select" name="title_size">
                          <option value = '1'>最大</option>
                          <option value = '2'>大</option>
                          <option value = '3'>标准 </option>

                          <option value = '4'> 小</option>
                          <option value = '5'>最小</option>
                      </select>
                  </div>
              </div>

              <div class="p-2 ">
                  <textarea class="form-control long-text" maxlength="8000" id ="edit_text_article_body" name="body"></textarea>
              </div>
              <hr>
              <div class = "row d-flex">
                  <div class=p-2>
                      <div class="form-check form-check-inline" name="use_info_check">
                          <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="use_info_checkbox"
                              value="1">
                          <label class="form-check-label" for="inlineCheckbox1">添加信息链接</label>
                      </div>
                  </div>

                  <div class="row d-flex align-items-center">
                      <div class="form-check form-check-inline">
                          <label class="form-check-label">链接显示类型</label>
                      </div>
                      <div id = 'info-radio'>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radio_button"
                                  value="button">
                              <label class="form-check-label" for="inlineRadio1">按钮</label>
                          </div>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radio_link"
                                  value="link">
                              <label class="form-check-label" for="inlineRadio2">超级链接</label>
                          </div>
                      </div>
                  </div>
              </div>
              <div class = "row d-flex" id="article_info_div">
                  <input type="text" class=" form-control info-name " id="article_info_title" name="info_title">
                  <img src="{{ asset('icons\link.svg') }}" class = " article-link-icon">
                  <select id="route_select" name="route" class=" form-control info-name ">
                      <!-- Add options here -->
                  </select>
              </div>
          </div>
          <input type="hidden" name="article_id" id = "article_id">
          <input type="hidden" name="row_id" id = "row_id">
          <input type='hidden' name="page_id" id = "page_id">
          <input type = "hidden" id="title_color" name="title_color">
          <input type="hidden" name ="form_name" value="edit_text_article">
          <input type="hidden" id="scroll_to" name = "scroll_to">

      </form>

      <div class="d-flex justify-content-end">
          <div class="p-2 ">
              <button type="button" id="cancel_article_edit" class="btn btn-secondary  article-button">
                  <img src="{{ asset('icons/close_empty.svg') }}" class = "article-button-icon">
              </button>
          </div>
          <div class="p-2 ">
              <button id ="edit_article_btn" class="btn btn-primary article-button">
                  <img src="{{ asset('icons/save.svg') }}" class = "article-button-icon">
              </button>
          </div>
      </div>

  </div>
  <style>
      .show-info-link {
          display: flex !important;
      }

      .hide-info-link {
          display: none !important;
      }

      .article-button-icon {
          height: 44px;

      }

      .article-button {
          display: flex;
          justify-content: center;
          align-items: center;
          padding: 3px !important;
          border: none;
          cursor: pointer;
          margin-right: 12px;

      }
  </style>
