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
                'icon' => 'icon-gc-base',
                'children' => [
                    [
                        'name' => '模块管理',
                        'icon' => 'icon-gc-modules',
                        'link' => $this->getSeedsModuleApiUri('base', 'modules'),
                    ]
                ]
            ]
        ];
    }

    public function getSeedsPermissionGroups (){
        return [
            // 模块化管理
            $this->getSeedsModuleMenuGroupName('base', '模块化管理') => [
                'base' . '.modules'
            ]
        ];
    }
}
