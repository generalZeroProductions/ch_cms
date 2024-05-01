<?php

namespace Database\Seeders;

use App\Models\ContentItem;
use App\Models\Navigation;
use App\Models\User;
use Illuminate\Database\Seeder;

class InitDbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            User::create([
                'name'=>'super',
                'password'=>bcrypt('123'),
                'super'=>true
            ]);
            Navigation::create([
                'type' => 'nav',
                'title'=>'Page_1',
                'route' => 'Page_1',
            ]);

            $column = ContentItem::create([
                'type'=> 'column',
                'heading' => 'title_text',
                'title' => 'Page 1 Title',
                'body' => 'This is some sample content.',
                
            ]);

            $rData = ['columns' => [$column->id]];

            $row = ContentItem::create([
                'type'=> 'row',
                'heading' => 'one_column',
                'data' => $rData,
                'index' => 0,
            ]);

            $pData = ['rows' => [$row->id]];

            ContentItem::create([
                'type'=> 'page',
                'title' => 'Page 1',
                'data' => $pData,
            ]);

            $this->command->info('Seeder executed successfully.');

        } catch (\Exception $e) {
            $this->command->error('Seeder encountered an error: ' . $e->getMessage());
        }
    }
}
