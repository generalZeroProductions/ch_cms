<?php
if (isset($_SESSION['screenWidth'])) {
    echo "<style>
        .banner_container {
            width: " . $_SESSION['screenWidth'] . "px;
            height: " . $_SESSION['screenWidth'] / 3 . "px;
            overflow: hidden; /* Ensure that the image is cropped to fit within the container */
        }

        .banner_container img {
            width: 100%; /* Make the image fill the width of the container */
            height: 100%; /* Make the image fill the height of the container */
            object-fit: cover; /* Crop the image to cover the container */
        }
    </style>";
}
$data = $row->data;
$slideList = $data['slides'];
$index = 0;
$editMode = true;
$slideshowId = 'slide_show_'.$row->id;
?>

@if(count($slideList)>0)

@if(count($slideList)>1)
<div id="{{$slideshowId}}" class="carousel slide" data-ride="carousel">
@if($editMode)
  <div class="row title_change_div">
            <div class="col-md-3" id = "{{ $row->id }}">
                <p class = "title_indicator"> Edit Slideshow</p>
                <a href="#"
                    onClick = "editSlidesForm('{{$slideshowId}}','{{ json_encode($row) }}')">
                    <img src="{{ asset('icons/pen.svg') }}" style = "margin-bottom: 4px; margin-left:8px">
                </a>
            </div>
        </div>
@endif
  <!-- Indicators -->
  <ul class="carousel-indicators">
  @foreach ($slideList as $img )

  @if($index === 0)
       <li data-target="#{{$slideshowId}}" data-slide-to="{{$index}}" class="active"></li>
       @else
        <li data-target="#{{$slideshowId}}" data-slide-to="{{$index}}1"></li>
       @endif
       @php
       $index+=1;
       @endphp
  @endforeach
  
  </ul>
   @php
       $index=0;
       @endphp
  <!-- The slideshow -->
  <div class="carousel-inner">
  @foreach ($slideList as $slide )
   @if($index === 0)
    <div class="carousel-item banner_container active">
    @else
     <div class="carousel-item banner_container">
    @endif
      <img src ="{{ asset('images/' . $slide['image'])}} " class = "image-fluid" >
    </div>
      @php
       $index+=1;
       @endphp
    @endforeach
  </div>
  
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#{{$slideshowId}}" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#{{$slideshowId}}" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>

@else

<div class="banner_container" id="{{$slideShowId}}">
@if($editMode)
  <div class="row title_change_div">
            <div class="col-md-3" id = "{{ $row->id }}">
                <p class = "title_indicator"> Edit Slideshow</p>
                <a href="#"
                    onClick = "editSlidesForm('{{$slideshowId}}','{{ json_encode($row) }}')">
                    <img src="{{ asset('icons/pen.svg') }}" style = "margin-bottom: 4px; margin-left:8px">
                </a>
            </div>
        </div>
@endif
<img src ="{{ asset('images/' . $slideList[0]['image']) }} " class = "image-fluid">
</div>
<label for="color">Choose a color:</label>
<input type="color" id="color" name="color">
@endif
@endif