  <div class="d-flex flex-column">
      <form id = "edit_text_article">
          @csrf

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

          <div class=row d-flex style="padding-left:4px">
              <div class=p-2>
                  <button type="button" onclick="addLink()" class = "btn btn-outline-secondary insert-html-btn">
                      <img src ="{{ asset('icons/link.svg') }}" class = "insert-html-link">
                  </button>
              </div>
              <div class=p-2>
                  <button type="button" onclick="removeLink('article')" class = "btn btn-outline-secondary insert-html-btn">
                      <img src ="{{ asset('icons/link_single.svg') }}" class = "insert-html-bold">
                  </button>
              </div>
              <div class=p-2>
                  <button type="button" onclick="boldSelected('article')" class = "btn btn-outline-secondary  insert-html-btn">
                      <img src ="{{ asset('icons/zi.svg') }}" class = "insert-html-bold">
                  </button>
              </div>
              <div class=p-2>
                  <button type="button" onclick="unboldSelected('article')" class = "btn btn-outline-secondary insert-html-btn">
                      <img src ="{{ asset('icons/zi_light.svg') }}" class = "insert-html-bold">
                  </button>
              </div>
          </div>
          <div id="htmlDiv" class="p-2" contenteditable="true" style="border: 1px solid black; min-height: 300px;">
              {{-- <textarea style="display: none;" class="form-control long-text" maxlength="8000" id ="edit_text_article_body"
                      name="body"></textarea> --}}
          </div>

          <br>
          <div class = "row d-flex" style="padding-left:12px">
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
          <div class = "row d-flex" id="article_info_div" style="padding-left:12px">
              <input type="text" class=" form-control info-name " id="article_info_title" name="info_title">
              <img src="{{ asset('icons\link.svg') }}" class = " article-link-icon">
              <select id="route_select" name="route" class=" form-control info-name ">
                  <!-- Add options here -->
              </select>
          </div>

          <input type="hidden" name="article_id" id = "article_id">
          <input type="hidden" name="row_id" id = "row_id">
          <input type='hidden' name="page_id" id = "page_id">
          <input type = "hidden" id="title_color" name="title_color">
          <input type="hidden" name ="form_name" value="edit_text_article">
          <input type="hidden" id="scroll_to" name = "scroll_to">
          <input type="hidden" name ="body" id = "htmlDivString">
      </form>

      <div class="d-flex justify-content-end">
          <div class="p-2 ">
              <button type="btn " id="cancel_article_edit" class="btn btn-secondary  article-button">
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

  <!-- Button to trigger the modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Open Modal
</button>

<!-- Link Modal -->
@include('forms.add_link_modal')


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

      .insert-html-bold {
          height: 18px;
          margin-bottom: 1px;
      }

      .insert-html-link {
          height: 18px;
          margin-bottom: 4px;
      }

      .insert-html-btn {
          padding: 4px;
          margin-left: 10px;
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
  <script></script>
