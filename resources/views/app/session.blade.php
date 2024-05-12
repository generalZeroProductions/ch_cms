@php
    use Illuminate\Support\Facades\Session;

    $currentUrl = $_SERVER['REQUEST_URI'];
    $urlParts = explode('/', $currentUrl);

    $parameters = end($urlParts);
    $parameterParts = explode('?', $parameters);
    $returnLocation;
    if ($parameterParts[0] === 'screen') {
        Session::put('screenwidth', $parameterParts[1]);
        Session::put('mobile', false);
        if ($parameterParts[1] < 800) {
            Session::put('mobile', true);
        }
        $returnLocation = '/' . $parameterParts[2];
    }
    if ($parameterParts[0] === 'cancel') {
        Session::put('returnPage', '');
        $returnLocation = '/' . $parameterParts[1];
        Session::put('location', $parameterParts[1]);
        Session::put('scrollTo', $parameterParts[2]);
    }

    if ($parameterParts[0] === 'edit') {
        Session::put('returnPage', '');
        Session::put('editMode', false);
        Session::put('buildMode', false);
        Session::put('scrollTo', $parameterParts[3]);
        Session::put('location', $parameterParts[2]);
        if ($parameterParts[1] === 'on') {
            Session::put('editMode', true);
            Session::put('scrollTo', $parameterParts[3]);
        }
        $returnLocation = '/' . $parameterParts[2];
    }

    if ($parameterParts[0] === 'build') {
        if ($parameterParts[1] === 'dashboard') {
            Session::put('location', $parameterParts[1]);
            Session::put('returnPage', '');
            Session::put('tabId', '');
            Session::put('scrollTo', 0);
            $returnLocation = '/' . $parameterParts[1];
        } else {
            Session::put('location', $parameterParts[1]);
            Session::put('returnPage', $parameterParts[2]);
            $returnLocation = '/' . $parameterParts[1];
        }

        Session::put('buildMode', true);
        Session::put('editMode', true);
    }
    if ($parameterParts[0] === 'endbuild') {
        Session::put('buildMode', false);
        $returnLocation = '/dashboard';
    }
    if ($parameterParts[0] === 'view') {
        Session::put('buildMode', false);
        Session::put('returnPage', '');
        $loc = $parameterParts[1];
        if ($parameterParts[1] === 'dashboard') {
            $loc = '';
        }
        $returnLocation = '/' . $loc;
    }

    if (isset($parameterParts[3])) {
        Session::put('scrollTo', $parameterParts[3]);
    }

  

@endphp
<script>
    window.onload = function() {
        window.location.href = "{{ $returnLocation }}";
    };
</script>
