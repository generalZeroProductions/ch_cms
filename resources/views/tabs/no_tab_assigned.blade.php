@php
    $routeSelectId = 'select_' . $rowId . $tabId;
    $saveRoute = 'save_' . $rowId . $tabId;
    $formName = 'form_asign_tab' . $rowId . $tabId;
@endphp

<div class="center-page site-blue">
    <div class="d-flex flex-column  mb-3">
        <div class="p-2">
            <p style = "padding:32px"> 通过 {{ $tabTitle }}</span> 链接分配一个页面通过链接分配页面。</p>
        </div>
        @if (!$mobile)
            <div class="p-2">
                <form id ="{{ $formName }}">
                    @csrf
                    <div class="row d-flex justify-content-end " style= "padding:24px">
                        <div class="p-2 " style= "font-size:24px; ">
                            从这里添加页面，或从标签编辑器中选择
                        </div>
                        <div class="p-2 flex-fill " style="margin-left:24px">
                            <select class= "form-control route-select" id="{{ $routeSelectId }}">
                                <option value = "select a route..">选择选项卡页面</option>
                            </select>
                        </div>
                        <input type="hidden" name="route" id="{{ $saveRoute }}">
                        <input type="hidden" name="tab_id" value="{{ $tabId }}">
                        <input type='hidden' name="tab_index" value="{{ $tabIndex }}">
                        <input type="hidden" name = "form_name" value = "tab_quick">

                    </div>
                </form>
            </div>
        @endif
    </div>
    <div class="no-route-scripts">
    <script>
        populateRoutesNoTab('{{ $pageId }}', '{{ $rowId }}', '{{ $tabIndex }}', '{{ $tabId }}');
    </script>

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


