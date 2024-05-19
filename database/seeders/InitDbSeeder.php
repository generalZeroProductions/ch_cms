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
                'name' => 'super',
                'password' => bcrypt('123'),
                'super' => true,
            ]);
            Navigation::create([
                'type' => 'nav',
                'title' => '主页',
                'route' => '主页',
                'index' => 0,
            ]);
            
            Navigation::create([
                'type'=>'logo',
                'data'=>['title'=>'1','image'=>1 ],
                'title'=>'标志文字',
                'route'=>'defaultImage.jpg'
            ] );
            $page = ContentItem::create([
                'type' => 'page',
                'title' => '主页',
            ]);
           
            $row = ContentItem::create([
                'type' => 'row',
                'heading' => 'one_column',
                'parent' => $page->id,
                'index' => 1,
                'body'=> '单栏文章'
            ]);
         
            $column = ContentItem::create([
                'type' => 'column',
                'heading' => 'title_text',
                'title' => '迎您来到新网站',
                'body' => '登录开始编辑。您的登录用户名“super”密码123',
                'styles'=> ['info'=>'on', 'title'=>'t3'],
                'parent'=>$row->id

            ]);
          
            Navigation::create([
                'type' => 'info',
                'title' => '登录',
                'route' => '/login',
                'styles'=>  ['type'=>'button'],
                'parent'=>$column->id

            ]);
            $this->command->info('Seeder executed successfully.');

        } catch (\Exception $e) {
            $this->command->error('Seeder encountered an error: ' . $e->getMessage());
        }
    }
}
