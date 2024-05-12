  @php
      use Illuminate\Support\Facades\Session;
      use App\Models\Navigation;
      use App\Models\ContentItem;
      use Illuminate\Support\Facades\Storage;
      use Illuminate\Support\Facades\View;
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

  @endphp
