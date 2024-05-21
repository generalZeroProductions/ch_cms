<div class="row">
    <div class = "col-6">
        <div class = "row" style="padding-left:14px">
            <div class=p-2>
                <button type="button" onclick="addLink()" class = "btn btn-outline-secondary insert-html-btn">
                    <img src ="{{ asset('icons/link.svg') }}" class = "insert-html-link">
                </button>
            </div>
            <div class=p-2>
                <button type="button" onclick="removeLink()" class = "btn btn-outline-secondary insert-html-btn">
                    <img src ="{{ asset('icons/link_single.svg') }}" class = "insert-html-bold">
                </button>
            </div>
            <div class= p-2>
                <button type="button" onclick="boldSelected()" class = "btn btn-outline-secondary  insert-html-btn">
                    <img src ="{{ asset('icons/zi.svg') }}" class = "insert-html-bold">
                </button>
            </div>
            <div class=p-2>
                <button type="button" onclick="unboldSelected()" class = "btn btn-outline-secondary insert-html-btn">
                    <img src ="{{ asset('icons/zi_light.svg') }}" class = "insert-html-bold">
                </button>
            </div>
        </div>
    </div>
    <div class = 'col-6 place-btn'>
        <button id = "sumbit_edit_footer" class = "btn btn-primary">
            <img src="{{ asset('icons/save.svg') }}">
        </button>
    </div>
</div>

<style>
    .place-btn {
        text-align: right;

    }
</style>
