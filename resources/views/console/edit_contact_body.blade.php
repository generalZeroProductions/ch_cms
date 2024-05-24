@php
    use App\Models\ContentItem;
    $contact = ContentItem::where('type', 'contact')->first();
    $title = $contact->title;
    $body = $contact->body;
    $data = $contact->data;
    $name_head = $data['name_head'];
    $contact_head = $data['contact_head'];
    $message_head = $data['message_head'];
    $name_warn = $data['name_warn'];
    $contact_warn = $data['contact_warn'];
    $message_warn = $data['message_warn'];
    $type1 = $data['contact_type_1'];
    $type2 = $data['contact_type_2'];
    $type3 = $data['contact_type_3'];
    $style = $contact->styles['title'];

@endphp

<div class="container">
    <div style="height:20px"></div>
    <div class="row align-items-center">
        <div class="col-1">
        </div>
        <div class="col-10">
            <br>
            <form id = "update_contact_form">@csrf
            <input type = "hidden" name="form_name" value="update_contact_form">
        
                <div class= "row flex-d">
                    <div class = "col-9">
                        <input type="text" class="form-control {{$style}}" id="edit_contact_title" name="title"
                            value="{{ $title }}" autocomplete="off">
                    </div>
                    <div class = "col-3">
                        <select class= "form-control" id="size_select_contact" name="size_select">
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
                <div class="form-row">
                   
                            <div class=" col-md-6">
                            </div>

                            <div class="col-md-6">
                                <div class = "row">
                                    <div class = "col-4">
                                        <input type = "text" class="form-control" value = "{{ $type1 }}" id ="contact_type_1" name="type_1">
                                    </div>
                                    <div class = "col-4">
                                        <input type = "text" class="form-control" value = "{{ $type2 }}" id ="contact_type_2" name="type_2">
                                    </div>
                                    <div class = "col-4">
                                        <input type = "text"  class="form-control" value = "{{ $type3 }}" id ="contact_type_3" name="type_3">
                                    </div>
                                </div>
                         
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input class="form-control" type = "text" value = "{{ $name_head }}" id="name_head"
                            name="name" autocomplete="off">
                        <br>
                        <input type="text" class="form-control " disabled>
                        <br>
                        <input class="form-control" type = "text" value = "{{ $name_warn }}" id="name_warn"
                            name="name_warn" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <input class="form-control" type = "text" value = "{{ $contact_head }}" id="contact_head"
                            name="contact" autocomplete="off">
                        <br>
                        <input type="text" class="form-control" disabled>
                        <br>
                        <input class="form-control" type = "text" value = "{{ $name_warn }}" id="contact_warn"
                            name="contact_warn" autocomplete="off">
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <input type="text" class="form-control" id="message_label" name="message"
                        value="{{ $message_head }}" autocomplete="off">
                    <br>
                    <textarea maxlength="2000" class="form-control contact-message" disabled id="inputAddress"></textarea>
                    <br>
                    <input type="text" class="form-control" id="message_warn" name="message_warn"
                        value="{{ $message_warn }}" autocomplete="off">
                </div>
                <div class = "form-row d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id ="submit_contact_update">
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
    .form-control::placeholder{
        color:white;
    }
</style>
