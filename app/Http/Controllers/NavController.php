<?php

namespace App\Http\Controllers;

use App\Helpers\NavMaker;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class NavController extends Controller
{
    public static function insert($formName)
    {
      
        if ($formName === 'edit_nav') {
            $htmlString = View::make('nav.forms.edit_standard_form')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } elseif ($formName === 'nav_delete') {
            $htmlString = View::make('nav.forms.delete_nav_form')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } elseif ($formName === 'add_nav') {
            $htmlString = View::make('nav.forms.add_nav_form')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } elseif ($formName === 'dropdown_editor_nav') {
            $htmlString = View::make('nav.forms.edit_dropdown_form')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } else {
            return response()->json(['error' => 'Invalid form name'], 400);
        }
    }
    public function write(Request $request)
    {
      
        if ($request->form_name === 'nav_delete') {
            $this->deleteNavItem($request);
        }
        if ($request->form_name === 'edit_nav') {
            $this->updateNavItem($request);
        }
        if ($request->form_name === 'dropdown_editor_nav') {
            $this->updateDropdown($request);
        }
        if ($request->form_name === 'add_standard_nav') {
            $this->addStandardNav($request);
        }
        if ($request->form_name === 'add_dropdown_nav') {

            $this->addDropdown($request);
        }
    }
    public static function render($render)
    {
      
        $data = explode('^', $render);
        if ($data[0] === 'navigation') {
            $navMake = new NavMaker();
            $htmlString = $navMake->navHTML($data[1]);
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } else {
            return response()->json(['error' => 'Invalid form name'], 400);
        }
    }

    private function updateNavItem(Request $request)
    {
        $navItem = Navigation::findOrFail($request->item_id);
        $navItem->title = $request->title;
        $navItem->route = $request->route;
        $navItem->save();
    }
    public function addStandardNav(Request $request)
    {
        $otherNav = Navigation::whereIn('type', ['nav', 'drop'])->get();
        $navCount = 0;
        if (!$otherNav->isEmpty()) {
            foreach ($otherNav as $nav) {
                if ($nav->index > $request->key) {
                    $nav->index = $nav->index + 1;
                    $nav->save();
                }
                if ($nav->type === "nav") {
                    $navCount++;
                }
            }
        }
        Navigation::create([
            'type' => 'nav',
            'index' => $request->key + 1,
            'title' => '新的导航项' . $navCount + 1,
            'route' => '/',
        ]);

    }

    public function deleteNavItem(Request $request)
    {
        $otherNav = Navigation::whereIn('type', ['nav', 'drop'])->get();

        if (!$otherNav->isEmpty()) {
            foreach ($otherNav as $nav) {
                if ($nav->index > $request->key) {
                    $nav->index = $nav->index - 1;
                    $nav->save();
                }
            }
        }
        $item = Navigation::find($request->item_id);
        if ($item->type === 'drop') {
            $subNavs = Navigation::where('parent', $item->id)->get();
            foreach ($subNavs as $sub) {
                $sub->delete();
            }
        }
        $item->delete();

        return redirect($request->location);
    }

    public function updateDropdown(Request $request)
    {
        $reqData = json_decode($request->data);
        $dropNav = Navigation::findOrFail($request->item_id);
        $dropNav->title = $request->title;
        $dropNav->save();
        foreach ($reqData as $sub) {
            if ($sub->record) {
                $route = $sub->route;
                if($sub->route==='选择页面路由')
                {
                    $route = '/';
                }
                $record = Navigation::findOrFail($sub->id);
                $record->index = $sub->index;
                $record->route = $route;
                $record->title = $sub->title;
                $record->save();
            } else {
                Navigation::create([
                    'type' => 'sub',
                    'route' => $sub->route,
                    'title' => $sub->title,
                    'parent' => $dropNav->id,
                    'index'=>$sub->index
                ]);
            }
        }
        if (isset($request->deleted)) {
            $deleteData = json_decode($request->deleted);
            foreach ($deleteData as $delete) {
                if ($delete->record) {
                    $remove = Navigation::findOrFail($delete->id);
                    $remove->delete();
                }
            }
        }
    }

    public function addDropdown(Request $request)
    {
        $otherNav = Navigation::whereIn('type', ['nav', 'drop'])->get();
        $dropCount = 1;

        if (!$otherNav->isEmpty()) {
            foreach ($otherNav as $nav) {
                if ($nav->index > $request->key) {
                    $nav->index = $nav->index + 1;
                    $nav->save();
                }
                if ($nav->type === 'drop') {
                    $dropCount++;
                }
            }
        }

        $dropDown = Navigation::create([
            'type' => 'drop',
            'index' => $request->key + 1,
            'title' => '新的下拉菜单' . $dropCount,
        ]);

        for ($i = 0; $i < 3; $i++) {
            Navigation::create([
                'type' => 'sub',
                'index' => $i,
                'title' => '子菜单' . $i,
                'route' => '/',
                'parent' => $dropDown->id,
            ]);
        }

    }
}
