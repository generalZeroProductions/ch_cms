@php
    use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
    $currentUrl = $_SERVER['REQUEST_URI'];
    $urlParts = explode('/', $currentUrl);
    $instructions = end($urlParts);
    $sequence = explode('?', $instructions);
    $returnLocation ='/';


    if ($sequence[0] === 'screen') {
        Session::put('screenwidth', $sequence[1]);
        Session::put('mobile', false);
        Session::put('mobile',$sequence[1] < 800);
        $returnLocation = '/' . $sequence[2];
    }
    if ($sequence[0] === 'cancel') {
        Session::put('returnPage', '');
        $returnLocation = '/' . $sequence[1];
        Session::put('location', $sequence[1]);
        Session::put('scrollTo', $sequence[2]);
    }
//edit?on?Page_1?0  
    if ($sequence[0] === 'edit') {
        Log::info('edit sequence '. $instructions);
        Session::put('returnPage', '');
        Session::put('editMode', false);
        Session::put('buildMode', false);
        Session::put('scrollTo', $sequence[3]);
        Session::put('location', $sequence[2]);
        if ($sequence[1] === 'on') {
            Session::put('editMode', true);
            Session::put('scrollTo', $sequence[3]);
        }
        $returnLocation = '/' . $sequence[2];
        Log::info('through edit on : return '. $returnLocation);
    }

    if ($sequence[0] === 'build') {
        if ($sequence[1] === 'dashboard') {
            Session::put('location', $sequence[1]);
            Session::put('returnPage', '');
            Session::put('tabId', '');
            Session::put('scrollTo', 0);
            $returnLocation = '/' . $sequence[1];
        } else {
            Session::put('location', $sequence[1]);
            Session::put('returnPage', $sequence[2]);
            $returnLocation = '/' . $sequence[1];
        }

        Session::put('buildMode', true);
        Session::put('editMode', true);
    }

 //   QUESTIONS HERE FOR SURE  PROBABLY COMBINE INTO BUILD
    if ($sequence[0] === 'endbuild') {
        Session::put('buildMode', false);
        $returnLocation = '/dashboard';
    }

    //   QUESTIONS HERE FOR SURE 
    if ($sequence[0] === 'view') {
        Session::put('buildMode', false);
        Session::put('returnPage', '');
        $loc = $sequence[1];
        if ($sequence[1] === 'dashboard') {
            $loc = '';
        }
        $returnLocation = '/' . $loc;
    }

    if (isset($sequence[3])) {
        Session::put('scrollTo', $sequence[3]);
    }

  

@endphp
<script>
    window.onload = function() {
        window.location.href = "{{ $returnLocation }}";
    };
</script>
