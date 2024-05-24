@php

@endphp

<div class="container-fluid">
    <div class="row d-flex">
        <div class = "col-6 blue-bar" id="single_footer_click">
            <div class = "row d-flex align-items-center justify-content-center">
                <label class = "slide-height-label">单栏页脚</label>
                <img src="{{asset('icons/single_footer2.svg')}}" class="footer-icon-1">
                <form id = 'single_footer_form'>
                @csrf
                    <input type="hidden" name = "form_name" value = "single_footer_form">
                </form>
            </div>
        </div>
        <div class = "col-6 blue-bar" id="double_footer_click">
            <div class = "row d-flex align-items-center justify-content-center">
                <label class = "slide-height-label"> 双栏页脚</label>
                <img src="{{asset('icons/double_footer.svg')}}" class="footer-icon-1">
                <img src="{{asset('icons/double_footer.svg')}}" class="footer-icon-1">
                <form id = 'double_footer_form'>
                @csrf
                    <input type="hidden" name = "form_name" value = "double_footer_form">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="footer_scripts">
    <script>
        changeFooterSetup('{{$footType}}');
    </script>

</div>
<style>

    .blue-bar {
        background-color:  rgb(178, 180, 249);
    }

    .blue-bar:hover {
        cursor: pointer;
        background-color:rgb(141, 145, 255);
    }
     .blue-bar-on {
        cursor: default;
        background-color:rgb(141, 145, 255);
    }

    .slide-height-label {
        font-size: 16px;
        font-weight: 650;
        color: white;
        margin-left: 18px;
        margin-right: 10px;
        margin-top: 8px;
    }
.footer-icon-2{
    margin-top:7px;
    height:18px;
}
.footer-icon-1{
    margin-top:2px;
    height:18px;
}
    .space-top {
        margin-top: 8px;
    }
</style>

