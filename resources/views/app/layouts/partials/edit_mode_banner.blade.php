  <div class ='edit-container'>
      <div class="row d-flex justify-content-end rounded-box">
       <div class="p-2 ">
       location ={{Session::get('location')}}
       </div>
          <div class="p-2 ">
          @if($buildMode)
buildMOde on
          @else
              @if ($editMode)
                  <button class="btn btn-success btn-top-console" id ="edit_switch_green"
                      onClick="setEditMode('off','{{ $route }}')">编辑模式
                      <img src="{{ asset('icons/switch_on.svg') }}" class="top-console-icon-edit">

                  </button>
              @else
                  <button class="btn btn-secondary btn-top-console" id ="edit_switch_gray"
                      onClick="setEditMode('on','{{ $route }}')">编辑模式
                      <img src="{{ asset('icons/switch_off.svg') }}" class="top-console-icon-edit">
                  </button>
              @endif
              @endif
          </div>
          <div class="p-2 "><button onClick="dashboardReturn()" class = "btn btn-secondary btn-top-console">仪表板
                  <img src = "{{ asset('/icons/meter.svg') }}" class="top-console-icon-dash">
              </button></div>
      </div>

  </div>


  <style>
      .btn-top-console {
          height: 100%;
          margin-left: 10px;
          margin-right: 10px;
          display: block;
          font-size: large !important;
          font-weight: 600 !important;
      }

      .top-console-icon-dash {
          height: 32px;
          margin-bottom: 4px;
          margin-left: 6px;
      }

      .top-console-icon-edit {
          height: 40px;
          margin-bottom: 4px;
          margin-left: 6px;
      }

      .edit-container {
          height: 90px;
          padding-top: 5px;
          padding-right: 5px;
          padding-left: 5px;
          padding-bottom: 5px;
      }

      .rounded-box {
          border-radius: 8px;
          padding: 2px;
          border: 2px solid #ccc;
      }
  </style>
