 <div class="carousel slide" data-ride="carousel" id = "{{ $slideshowId }}">
     <!-- Indicators -->
     <ul class="carousel-indicators">
         @foreach ($slideList as $slide)
             @if ($index === 0)
                 <li data-target="#{{ $slideshowId }}" data-slide-to="{{ $index }}" class="active">
                 </li>
             @else
                 <li data-target="#{{ $slideshowId }}" data-slide-to="{{ $index }}1"></li>
             @endif
             @php
                 $index += 1;
             @endphp
         @endforeach

     </ul>
     @php
         $index = 0;
     @endphp
     <!-- The slideshow -->
     <div class="carousel-inner">
         @foreach ($slideList as $slide)
             @if ($index === 0) 
             <div class="carousel-item banner_container active">
                 @else
                     <div class="carousel-item banner_container">
            @endif
                 <img src ="{{ asset('images/' . $slide->image) }} " class = "image-fluid">
                 <div class="carousel-caption d-none d-md-block">
                     <h2>{{ $slide->body }}</h2>
                 </div>
             </div>
             @php
                 $index += 1;
             @endphp
         @endforeach
         <a class="carousel-control-prev" href="#{{ $slideshowId }}" data-slide="prev">
             <span class="carousel-control-prev-icon"></span>
         </a>
         <a class="carousel-control-next" href="#{{ $slideshowId }}" data-slide="next">
             <span class="carousel-control-next-icon"></span>
         </a>
     </div>
</div>