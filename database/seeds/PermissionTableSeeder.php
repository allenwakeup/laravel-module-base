<?php

namespace Goodcatch\Modules\Base\Database\Seeders;

use Goodcatch\Modules\Base\Traits\PermissionSeedsTrait;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    use PermissionSeedsTrait;

    public function getSeedsMenus (){
        return [
            [
                'name' => '系统模块',
                'children' => [
                    [
                        'name' => '模块管理',
                        'link' => $this->getSeedsApiUri('modules'),
                    ]
                ]
            ]
        ];
    }

    public function getSeedsPermissionGroups (){
        return [
            '模块化管理' => [
                'modules'
            ]
        ];
    }
}
