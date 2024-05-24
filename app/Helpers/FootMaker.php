<?php
namespace App\Helpers;

use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class FootMaker
{
    function makeFooter()
    {
        $site = Navigation::where('type', 'site')->first();
       
        $footer1 = ContentItem::where('type','footer1')->first();
        $footer2 = ContentItem::where('type','footer2')->first();
        $footer3 = ContentItem::where('type','footer3')->first();
        $foots1 = ContentItem::where('parent',$footer1->id)->get();
        $foots2 = ContentItem::where('parent',$footer2->id)->get();
        $foots3 = ContentItem::where('parent',$footer3->id)->get();
        Log::info('site is');
        Log::info($site);
        $htmlString = View::make('footer.footer', [
            'footType' => $site->data['footer'],
            'foots1'=>$foots1,
            'foots2'=>$foots2,
            'foots3'=>$foots3,
            'editMode'=>Session::get('editMode')
        ]);
        return $htmlString;
    }

}
