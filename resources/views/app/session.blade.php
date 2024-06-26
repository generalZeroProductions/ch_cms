@php
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Log;
    $currentUrl = $_SERVER['REQUEST_URI'];
    $urlParts = explode('/', $currentUrl);
    $instructions = end($urlParts);
    $sequence = explode('?', $instructions);
    $returnLocation = '/';

    if ($sequence[0] === 'screen') {
        Session::put('screenwidth', $sequence[1]);
        Session::put('mobile', false);
        Session::put('mobile', $sequence[1] < 800);
        $returnLocation = '/' . $sequence[2];
    }
    if ($sequence[0] === 'cancel') {
        Session::put('returnPage', '');
        $returnLocation = '/' . $sequence[1];
        Session::put('scrollTo', $sequence[2]);
    }
    //edit?on?Page_1?0
    if ($sequence[0] === 'edit') {
        Log::info('edit sequence ' . $instructions);
        Session::put('returnPage', '');
        Session::put('editMode', false);
        Session::put('buildMode', false);
        if ($sequence[1] === 'on') {
            Session::put('editMode', true);
        }
        $returnLocation = '/' . $sequence[2];
        Log::info('edit return to ' . $sequence[2]);
        Session::put('scrollTo', $sequence[3]);
    }

    if ($sequence[0] === 'build') {
        Log::info('enter build mode ' . $instructions);
        Session::put('buildMode', true);
        Session::put('editMode', true);
        $returnLocation = '/' . $sequence[1];
        Session::put('returnPage', $sequence[2]);
        if (isset($sequence[3])) {
            Session::put('scrollTo', 'rowInsert' . $sequence[3]);
        }
    }

    //   QUESTIONS HERE FOR SURE  PROBABLY COMBINE INTO BUILD
    if ($sequence[0] === 'endbuild') {
        Session::put('buildMode', false);
        $returnLocation = '/dashboard';
    }

    //   QUESTIONS HERE FOR SURE
    if ($sequence[0] === 'view') {
        Session::forget('returnPage');
        Session::forget('scrollTo');
        Session::put('buildMode', false);
        $loc = $sequence[1];
        if ($sequence[1] === 'dashboard') {
            $loc = '';
        }
        Log::info($sequence);
        if(isset($sequence[2])){
            Session::put('scrollTo', $sequence[2]);
        }
        $returnLocation = '/' . $loc;
    }

    if ($sequence[0] === 'scroll') {
        Session::put('scrollTo', $sequence[1]);
    }
    if ($sequence[0] === 'key') {
        $returnLocation = '/' . $sequence[1];
        Session::put('navKey', $sequence[2]);
    }

@endphp
<script>
    window.onload = function() {
        window.location.href = "{{ $returnLocation }}";
    };
</script>
