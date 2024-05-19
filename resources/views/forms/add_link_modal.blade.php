<div class="modal fade" id="linkModal" tabindex="-1" role="dialog" aria-labelledby="linkModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="linkModalLabel">创建超链接</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p>要在该网站内建立链接，只需输入页面标题，例如“联系我们”。要链接到本网站之外的页面，请输入完整的 URL，例如“https://www.baidu.com/”</p>
        <div class="form-group">
          <label for="hrefInput">链接参考:</label>
          <input type="text" class="form-control" id="hrefInput" placeholder="Enter link href" autocomplete="off">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveLink()">Save</button>
      </div>
    </div>
  </div>
</div>