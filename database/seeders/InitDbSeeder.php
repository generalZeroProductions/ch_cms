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
                'type' => 'logo',
                'data' => ['title' => '1', 'image' => 1],
                'title' => '标志文字',
                'route' => 'defaultImage.jpg',
            ]);
            $page = ContentItem::create([
                'type' => 'page',
                'title' => '主页',
            ]);

            $row = ContentItem::create([
                'type' => 'row',
                'heading' => 'one_column',
                'parent' => $page->id,
                'index' => 1,
                'body' => '单栏文章',
            ]);

            $column = ContentItem::create([
                'type' => 'column',
                'heading' => 'title_text',
                'title' => '迎您来到新网站',
                'body' => '登录开始编辑。您的登录用户名“super”密码123',
                'styles' => ['info' => 'on', 'title' => 't3'],
                'parent' => $row->id,

            ]);

            Navigation::create([
                'type' => 'info',
                'title' => '登录',
                'route' => '/login',
                'styles' => ['type' => 'button'],
                'parent' => $column->id,

            ]);

            Navigation::create([
                'type' => 'site',
                'title'=>'site',
                'data' => ['footer' => 'single'],
            ]);
            $foot1 = ContentItem::create([
                'type' => 'footer1',
            ]);

            ContentItem::create([
                'type' => 'foot_item',
                'parent' => $foot1->id,
                'body' => '公司详细信息或联系信息',
            ]);
            ContentItem::create([
                'type' => 'foot_item',
                'parent' => $foot1->id,
                'body' => '公司详细信息或联系信息',
            ]);
            $foot2 = ContentItem::create([
                'type' => 'footer2',
            ]);
            ContentItem::create([
                'type' => 'foot_item',
                'parent' => $foot2->id,
                'body' => '公司详细信息或联系信息',
            ]);
            ContentItem::create([
                'type' => 'foot_item',
                'parent' => $foot2->id,
                'body' => '公司详细信息或联系信息',
            ]);

            $foot3 = ContentItem::create([
                'type' => 'footer3',
            ]);
            ContentItem::create([
                'type' => 'foot_item',
                'parent' => $foot3->id,
                'body' => '公司详细信息或联系信息',
            ]);
            ContentItem::create([
                'type' => 'foot_item',
                'parent' => $foot3->id,
                'body' => '公司详细信息或联系信息',
            ]);
    
            ContentItem::create([
                'type' => 'contact',
                'heading' => 'title_text',
                'title'=> '我们该怎样帮助你？',
                'body' => '给我们留言，我们会回复您！',
                'styles'=> ['title'=>'t3'],
                'data'=>  [
                    'name_head'=>'姓名',
                    'name_warn'=>'别忘了写上名字',
                    'contact_head'=>'最佳连接方式',
                    'contact_warn'=>'不要忘记留下联系方式',
                    'message_head'=>'询问',
                    'message_warn'=>'别忘了留言',
                    'contact_type_1'=>'微信',
                    'contact_type_2'=>'手机',
                    'contact_type_3'=>'电子邮件',
                ]
            ]);
            ContentItem::create([
                'type' => 'thankyou',
                'heading' => 'title_text',
                'title'=> '感谢您的关注',
                'body' => '我们会尽快与您联系。',
                'styles'=> ['title'=>'t3']
            ]);
            $this->command->info('Seeder executed successfully.');

        } catch (\Exception $e) {
            $this->command->error('Seeder encountered an error: ' . $e->getMessage());
        }
    }
}
