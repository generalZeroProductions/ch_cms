@php
    use Illuminate\Support\Facades\Session;
    use App\Models\Navigation;
    use App\Models\ContentItem;
    use Illuminate\Support\Facades\Storage;
      use Illuminate\Support\Facades\View;
    function displayPage()
    {
        $htmlString = View::make('app.first_page')->render();
        return $htmlString;
    }
@endphp
