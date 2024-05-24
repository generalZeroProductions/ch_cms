@php
    use App\Models\ContentItem;
    $contact = ContentItem::where('type', 'thankyou')->first();
    $title = $contact->title;
    $body = $contact->body;
    $style = $contact->styles['title'];

@endphp

<div class="container">
    <div style="height:20px"></div>
    <div class="row align-items-center">
        <div class="col-1">
        </div>
        <div class="col-10">
            <br>
            <form id = "update_thankyou_form">@csrf
                <input type = "hidden" name="form_name" value="update_thankyou_form">
                <div class= "row flex-d">
                    <div class = "col-9">
                        <input type="text" class="form-control {{ $style }}" id="edit_thankyou_title"
                            name="title" value="{{ $title }}" autocomplete="off">
                    </div>
                    <div class = "col-3">
                        <select class= "form-control" id="size_select_thankyou" name="size_select">
                            <option value = '1'>最大</option>
                            <option value = '2'>大</option>
                            <option value = '3'>标准 </option>

                            <option value = '4'> 小</option>
                            <option value = '5'>最小</option>
                        </select>
                    </div>
                </div>
                <br>
                <textarea maxlength="2000" class="form-control write-message" id="contact_body" name="body">{{ $body }}</textarea>
                <br>

                <br>

                <hr>

                <div class = "form-row d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id ="submit_thankyou_update">
                        <img src = "{{ asset('icons/save.svg') }}" style="height:24px">
                    </button>
                </div>
            </form>
        </div>

        <div class="col-1">

        </div>
    </div>
</div>
<div style="height:90px"></div>

<style>
    .contact-message {
        height: 60px
    }

    .write-message {
        height: 160px;
    }

    .form-control::placeholder {
        color: white;
    }
</style>
