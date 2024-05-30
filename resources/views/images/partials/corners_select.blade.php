@php
 $width = Session::get('screenwidth') / 6;
 $margin = $width*0.2026;
 $top = 280;
echo '<style> .stack_2 {
        position:absolute;
           z-index: 2;
           top:'.$top.'px;
           left:'.$margin.'px;
           width:'.$width . 'px;
       }</style>  '
@endphp
   
   
   <div class = "stack_2">
       <div id="imageRadios" class = "corners-bar">
           <div class="d-flex justify-content-around">
               <div class = "p-2 corner" id="image_square">
                   <img src="{{ asset('icons/square2.svg') }}"class="select-corners">
               </div>
               <div class = "p-2 corner" id="image-thumb-rounded">
                   <img src="{{ asset('icons/rounded.svg') }}"class="select-corners">
               </div>
               <div class = "p-2 corner" id="rounded-circle">
                   <img src="{{ asset('icons/circle.svg') }}" class = "select-corners">
               </div>
           </div>
       </div>

   </div>
   <style>
       .corner {
           text-align: center;
           width: 100%;
           background-color: rgb(191, 195, 198);
       }

      

       .corner:hover {
           background-color: rgb(184, 211, 231);
       }

       .corner.selected {
           width: 100%;
           background-color: rgb(117, 185, 241);
       }

       .corners-bar {
           margin-bottom: 10px;
       }

       input[type="radio"] {
           display: none;
       }


       .radio-icon {
           display: inline-block;
           width: 20px;
           /* Adjust as needed */
           height: 20px;
           /* Adjust as needed */
           border: 1px solid #ccc;
           /* Example border */
           border-radius: 50%;
           /* Make it circular */
           text-align: center;
           line-height: 20px;
           /* Center content vertically */
       }
   </style>
