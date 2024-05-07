  @php
      use Illuminate\Support\Facades\Session;
      use App\Models\Navigation;
      use App\Models\ContentItem;
      use Illuminate\Support\Facades\Storage;
      use Illuminate\Support\Facades\View;
      $editMode = false;
      $mobile = false;
      $buildMode = false;
      function allRows($rowData)
      {
          $allRows = [];
          foreach ($rowData as $row_id) {
              $nextRow = ContentItem::findOrFail($row_id);
              if ($nextRow) {
                  $allRows[] = $nextRow;
              }
          }
          usort($allRows, 'sortByIndex');
          return $allRows;
      }
      function getTabContents($tabs, $rowId)
      {
          $mobile = getMobile();
          $contents = [];
          foreach ($tabs as $tab) {
              $page = ContentItem::where('type', 'page')
                  ->where('title', $tab->route)
                  ->first();

              $location = [
                  'page' => $page,
                  'row' => null,
                  'item' => null,
                  'scroll' => null,
              ];
              if ($tab->route === 'no_tab_assigned') {
                  $content = View::make('tabs.no_tab_assigned', [
                      'location' => $location,
                      'tabContent' => true,
                      'mobile' => $mobile,
                      'tabId' => $tab->id,
                      'tabTitle' => $tab->title,
                      'rowId' => $rowId,
                  ])->render();
                  $contents[] = $content;
              } else {
                  $content = View::make('app.page_layout', [
                      'location' => $location,
                      'tabContent' => true,
                      'tabId' => $tab->id,
                      'mobile' => $mobile,
                  ])->render();
                  $contents[] = $content;
              }
          }
          return $contents;
      }

      function findTab($tabAt)
      {
          return Navigation::findOrFail($tabAt);
      }
      function tabsList($tabData)
      {
          $tabs = [];
          foreach ($tabData as $tabId) {
              $nextTab = Navigation::findOrFail($tabId);
              if ($nextTab) {
                  $tabs[] = $nextTab;
              }
          }
          usort($tabs, 'sortByIndex');

          return $tabs;
      }

      function getPage($pageName)
      {

          return ContentItem::where('type', 'page')->where('title', $pageName)->first();
      }
      function setAllRoutes()
      {
          $getRoutes = ContentItem::where('type', 'page')->pluck('title')->toArray();
          $allRoutes = json_encode($getRoutes);
          $directory = 'public/images';
          $files = Storage::allFiles($directory);
          $allImages = [];
          foreach ($files as $file) {
              if ($file !== '.' && $file !== '..') {
                  $allImages[] = pathinfo($file, PATHINFO_BASENAME);
              }
          }
          return $allRoutes;
      }
      function sortByIndex($a, $b)
      {
          return $a['index'] - $b['index'];
      }

      function getEditMode()
      {
          if (Session::has('editMode')) {
              return Session::get('editMode');
          }
          return false;
      }

      function getBuildMode()
      {
          if (Session::has('buildMode')) {
              return Session::get('buildMode');
          }
          return false;
      }

      function getMobile()
      {
          if (Session::has('mobile')) {
              return Session::get('mobile');
          }
          return false;
      }
      function getScroll()
      {
        if(Session::has('scrollTo'))
        {
            return Session::get('scrollTo');
        }
        return 0;
      }

      function getTabTrack()
      {
          $tabTrack = null;
          if (Session::has('tabTrack')) {
              $tabTrack = Session::get('tabTrack');
          }
          Session::put('tabTrack', null);
          return $tabTrack;
      }
      

      function getHeadspace()
      {
          $headSpace = 57;
          if (Auth::check()) {
              $headSpace = 168;
              if (Session::has('edit')) {
                  $editMode = Session::get('edit');
                  if ($editMode) {
                      $headSpace = 196;
                  }
                  if ($tabContent) {
                      $backColor = '#cecece';
                  }
              }
              if (Session::has('buildMode')) {
                  $buildMode = Session::get('buildMode');
                  if ($buildMode) {
                      $headSpace = 91;
                  }
              }
          }
          return $headSpace;
      }

  @endphp
