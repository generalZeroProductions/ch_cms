@php
    Log::info('working in contact');
    $data = $column->data;
    $name_head = $data['name_head'];
    $contact_head = $data['contact_head'];
    $message_head = $data['message_head'];
    $name_warn = $data['name_warn'];
    $contact_warn = $data['contact_warn'];
    $message_warn = $data['message_warn'];
    $type1 = $data['contact_type_1'];
    $type2 = $data['contact_type_2'];
    $type3 = $data['contact_type_3'];
    $style = $column->styles['title'];
@endphp

<div class="d-flex flex-column rowInsert">
    <div style="height:20px"></div>
    <div class="row align-items-center">
        <div class="col-1">
        </div>
        <div class="col-10" id='contact_us_div'>
            @include('console.contact_body', ['column' => $column])
            <br>
            <form id ="client_contact_form">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-9">
                    </div>
                    <div class="form-group col-md-3">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-outline-info active" value={{$type1}}
                                name="contactMethod">{{ $type1 }}</button>
                            <button type="button" class="btn btn-outline-info" value={{$type2}}
                                name="contactMethod">{{ $type2 }}</button>
                            <button type="button" class="btn btn-outline-info" value={{$type3}}
                                name="contactMethod">{{ $type3 }}</button>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">{{ $name_head }}</label>
                        <input type="text" class="form-control" id="name" name ="name" autocomplete="off">
                        <label id="no_name" style="display:none; color:red">{{ $name_warn }}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="contact_info">{{ $contact_head }} </label>
                        <input type="text" class="form-control" id="contact_info" name ="contact_info"
                            autocomplete="off">
                        <label id="no_contact" style="display:none; color:red">{{ $contact_warn }}</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="message_body">{{ $message_head }}</label>
                    <textarea maxlength="2000" class="form-control contact-message" id="message_body" placeholder="" name="body"></textarea>
                    <label id="no_message" style="display:none; color:red">{{ $message_warn }} </label>
                </div>
               
                <input type="hidden" id="contact_type" name="contact_type" value="0">
                <input type="hidden" name="form_name" value="client_contact_form">
            </form>
             <div class = "form-row d-flex justify-content-end">
                    <button class="btn btn-primary" id ="submit_contact_btn">
                        提交询问
                    </button>
                </div>
        </div>

        <div class="col-1">
        </div>
    </div>
</div>
<div style="height:90px"></div>
</div>
<style>
    .contact-message {
        height: 240px
    }
</style>

<div class="contactScript">
    <script>
        setupContactForm('none');
    </script>
</div>
