<div class="center-page site-blue">

    <div class="d-flex flex-column  mb-3">
        <div class="p-2">
            <p> 通过 <span id = "no-tab-content"></span> 链接分配一个页面通过链接分配页面。</p>
        </div>

        <div class="p-2">
            <form method= 'POST'action="/quick_tab_asign" id ="tab_quick_select">
            @csrf
                <div class="row d-flex justify-content-end " style= "margin-right:24px">
                    <div class="p-2 flex-fill " style= "font-size:24px">
                        从这里添加页面，或从标签编辑器中选择
                    </div>
                    <div class="p-2 flex-fill ">
                        <select class= "form-control" id="no_tab_route_select">
                            <option value = "select a route..">select a route</option>
                        </select>
                    </div>
                    <input type="hidden" name="route" id="route">
                    <input type="hidden" name="tab_id" id="quick_tab_id">
                    <input type="hidden" name = "scroll_to" id="tab_scroll_to">
                </div>
            </form>
        </div>
    </div>
</div>


<style>
    .center-page {
        margin: 0;
        height: 500px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, sans-serif;
        font-size: 34px;
        font-weight: 500;
        color: white;
    }

    .link-name {
        color: rgb(215, 215, 201);
        font-weight: 600;
    }
</style>

<div id="runScriptTab">
    <script>
        populateRoutesNoTab();
    </script>
</div>
