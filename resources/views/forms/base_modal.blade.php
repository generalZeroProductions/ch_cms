
<link rel="stylesheet" href="{{ asset('scripts/bootstrap.min.css') }}">

<div class="modal fade" id="baseModal">
  <div class="modal-dialog" id = "base-modal-size">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="base-modal-title"></h4>
        <a href="#" onClick="closeModal('baseModal')"><img src="{{asset('icons/close.svg')}}" class = 'slide_edit_icon'></a>
        {{-- <button type="button" class="close"  onClick="closeModal('baseModal')">&times;</button> --}}
      </div>
      <!-- Modal Body -->
      <div class="modal-body text-center" id="base-modal-content">
        <!-- Content goes here -->
      </div>
    </div>
  </div>
</div>