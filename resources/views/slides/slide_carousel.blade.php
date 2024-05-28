 <div class="carousel slide" data-ride="carousel" data-interval="5000" id="{{ $slideshowId }}">
     <!-- Indicators -->
     <ul class="carousel-indicators">
         @foreach ($slideList as $index => $slide)
             <li data-target="#{{ $slideshowId }}" data-slide-to="{{ $index }}"
                 class="{{ $index === 0 ? 'active' : '' }}"></li>
         @endforeach
     </ul>

     <!-- The slideshow -->
     <div class="carousel-inner">
         @foreach ($slideList as $index => $slide)
             <div class="carousel-item banner_container {{ $index === 0 ? 'active' : '' }}">
                 <img src="{{ asset('images/' . $slide->image) }}" class="img-fluid" alt="Slide {{ $index + 1 }}">
                 <div class="carousel-caption d-none d-md-block">
                     <h2>{{ $slide->body }}</h2>
                 </div>
             </div>
         @endforeach
     </div>

     <!-- Controls -->
     <a class="carousel-control-prev" href="#{{ $slideshowId }}" data-slide="prev">
         <span class="carousel-control-prev-icon"></span>
     </a>
     <a class="carousel-control-next" href="#{{ $slideshowId }}" data-slide="next">
         <span class="carousel-control-next-icon"></span>
     </a>
 </div>


 <div class = "carousel_scripts">

     <script>
         startCarousel('{{ $slideshowId }}');
     </script>

 </div>


 <style>
     .carousel-caption h2 {
         text-shadow: 1px 1px 2px black;
     }
 </style>
