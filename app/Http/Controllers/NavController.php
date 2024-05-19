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
        Log::info('nav insert calling: ' . $formName);
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
        Log::info('At Write: ' . $request->form_name);
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
        Log::info('@render nav request');
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
            $subNavs = Navigation::where('parent', $item->id);
            foreach ($subNavs as $sub) {
                $sub->delete();
            }
        }
        $item->delete();

        return redirect($request->location);
    }

    public function updateDropdown(Request $request)
    {
        Log::info('update nav request');
        Log::info($request);
        $reqData = json_decode($request->data);
        $dropNav = Navigation::findOrFail($request->item_id);
        $dropNav->title = $request->title;
        $dropNav->save();
        foreach ($reqData as $sub) {
            if (isset($sub->id)) {
                $record = Navigation::findOrFail($sub->id);
                $record->index = $sub->index;
                $record->route = $sub->route;
                $record->title = $sub->title;
                $record->save();
            } else {
                Navigation::create([
                    'type' => 'sub',
                    'route' => $sub->route,
                    'title' => $sub->title,
                    'parent' => $dropNav->id,
                ]);
            }
        }
        if (isset($request->deleted)) {
            $deleteData = json_decode($request->deleted);
            foreach ($deleteData as $delete) {
                if (isset($delete->id)) {
                    $remove = Navigation::findOrFail($delete->id);
                    $remove->delete();
                }
            }
        }
    }

    public function addDropdown(Request $request)
    {
        Log::info('add drop request');
        Log::info($request);

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
            'route' => null,
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
