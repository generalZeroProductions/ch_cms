@php

  $editMode = Session::get('editMode');
   $currentUrl = urldecode($_SERVER['REQUEST_URI']);
        $urlParts = explode('/', $currentUrl);
@endphp

<div class="center-page site-blue">
    <div class="d-flex flex-column  mb-3">
        <div class="p-2" >
            <p style = "padding:32px"> 无法在此位置找到任何内容</p>
        </div>
        @if ($editMode)
            <div class="p-2">
                <form method= 'POST' id ="page_quick">
                    @csrf
                    <div class="row d-flex justify-content-end align-items-center" style= "padding:24px">
                        <div class="p-2 " style= "font-size:24px; ">
                           您想为此路线创建一个新页面吗？
                        </div>
                        <div class="p-2 flex-fill " style="margin-left:24px">
                          <button type="submit" class = "btn btn-secondary"> 制作新页面</button>
                        </div>
                        <input type="hidden" name="route" id="save_route">
                        <input type="hidden" name = "form_name" value = "page_quick">
                      
                     </div>
                </form>
            </div>
        @endif
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

</style>

<div class="no-page-scripts">
<script>
  populateRoutesNoPage();
</script>

</div>

