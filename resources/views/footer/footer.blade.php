

@if($editMode)
@include('footer.footer_split_select', ['footType'=>$footType])
@endif
<div class="container-fluid navbar-light bg-light footer">
@if ($footType === 'single')
    <div class="row d-flex justify-content-center" id="footDiv3">
    <div class= "col12">
        @include('footer.foot_column', ['items' => $foots3, 'divId'=>'footDiv3'])
        </div>
    </div>
@else
    <div class="container ">
        <div class="row">
            <div class="col-6" id = "footDiv1" >
                @include('footer.foot_column', ['items' => $foots1,'divId'=>'footDiv1'])
            </div>
            <div class="col-6" id="footDiv2">
                @include('footer.foot_column', ['items' => $foots2,'divId'=>'footDiv2'])
            </div>
        </div><!-- Content here -->
    </div>
@endif
<br>
<br>
</div>

<style>
.footer{
    padding-top:18px;
    font-weight:500;
    padding-bottom:22px;
}
</style>