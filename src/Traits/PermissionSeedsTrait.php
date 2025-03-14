<?php

namespace Goodcatch\Modules\Base\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait PermissionSeedsTrait{

    /**
     * pre-defined admin role
     * @var string admin role id
     */
    protected $admin_role_id = 1;
    /**
     * @var string table name
     */
    protected $tb_permission_group = 'permission_groups';
    /**
     * @var string table name for permission
     */
    protected $tb_permissions = 'permissions';
    /**
     * @var string table name for all menus
     */
    protected $tb_menus = 'menus';
    /**
     * @var string table name for role menu mappings
     */
    protected $tb_role_menus = 'role_menus';
    /**
     * @var string table name for role permission mappings
     */
    protected $tb_role_permissions = 'role_permissions';
    /**
     * all of modules api uri should follow it
     * @var string api uri prefix
     */
    protected $api_prefix = 'Admin/goodcatch';
    /**
     * @var array default api resource actions
     */
    protected $api_actions = [
        'index' => ['name' => '列表', 'content' => '列表展示'],
        'store' => ['name' => '添加', 'content' => '数据添加'],
        'show' => ['name' => '详情', 'content' => '单个详情'],
        'update' => ['name' => '修改', 'content' => '数据修改'],
        'destroy' => ['name' => '删除', 'content' => '数据删除']
    ];

    /**
     * generate api uri
     * @param string $path
     * @return string
     */
    protected function getSeedsApiUri ($path = '')
    {
        return '/' . $this->api_prefix . (empty ($path) ? '' : ('/' . $path));
    }

    /**
     * generate api uri
     * @param $module
     * @param string $path
     * @return string
     */
    public function getSeedsModuleApiUri ($module, $path = '')
    {
        return $this->getSeedsApiUri(module_route_prefix('/' . $module)) .  (empty ($path) ? '' : ('/' . $path));
    }

    /**
     * generate module group name
     * @param $name
     * @param $model_name
     * @return string
     */
    public function getSeedsModuleMenuGroupName ($name, $model_name){
        return $name .  (empty ($model_name) ? '' : ('-' . $model_name));
    }

    /**
     * append other api resource action for permission data
     *
     * @param $name string action
     * @param $data array additionally permission data
     */
    protected function appendSeedsApiActions ($name, $data){
        if(!empty($name) && !Arr::has($this->api_actions, $name)){
            $this->updateSeedsApiActions($name, $data);
        }
    }

    /**
     * update api resource action
     *
     * @param $name string action
     * @param $data array additionally permission data
     */
    protected function updateSeedsApiActions ($name, $data){
        $this->api_actions[$name] = $data;
    }

    /**
     * @return string[][]
     */
    protected function getSeedsApiActions (){
        return $this->api_actions;
    }


    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $this->addSeedsMenu(
            0,
            $this->getSeedsMenus()
        );

        foreach($this->getSeedsPermissionGroups() as $group => $resources){
            $t_permission_groups = DB::table($this->tb_permission_group);

            $permission_group = $t_permission_groups->where('name', $group)->first();
            $group_id = isset($permission_group)
                ? $permission_group->id
                : $t_permission_groups->insertGetId(['name' => $group]);

            foreach($resources as $resource => $spec_apis_actions){
                $api_actions = $this->getSeedsApiActions();
                $resource_name = $spec_apis_actions;
                if(is_array($spec_apis_actions)){
                    $api_actions = $spec_apis_actions;
                    $resource_name = $resource;
                }
                foreach($api_actions as $action => $data){
                    $apis = $resource_name . '.' . $action;
                    $unique = [
                        'apis' => $apis,
                        'pid' => $group_id
                    ];
                    unset($data['apis']);
                    unset($data['pid']);
                    $t_permissions = DB::table($this->tb_permissions);
                    $t_permissions->updateOrInsert($unique, $data);
                    $this->addSeedsRolePermissions(
                        $this->admin_role_id,
                        $unique
                    );
                }
            }
        }
    }

    private function addSeedsMenu($pid = 0, $menus = []){
        if(count($menus) > 0){
            foreach($menus as $k => $menu){
                $name = Arr::get($menu, 'name');
                $link = Arr::get($menu, 'link', '#');
                $icon = Arr::get($menu, 'icon', '');
                $is_type = Arr::get($menu, 'is_type', 0);
                $unique = [
                    'name'  => $name,
                    'link'  => $link,
                    'pid'   => $pid,
                ];
                DB::table($this->tb_menus)->updateOrInsert($unique, [
                    'icon'  => $icon,
                    'is_type' => $is_type
                ]);
                $children = Arr::get($menu, 'children', []);
                $created = DB::table($this->tb_menus)->where($unique)->first();
                if(empty($children)){
                    $this->addSeedsRoleMenus($this->admin_role_id, $created);
                }else{
                    $this->addSeedsMenu($created->id, $children);
                }
            }
        }
    }

    private function addSeedsRoleMenus($role_id, $menu){
        if(isset($menu)){
            $t_role_menus = DB::table($this->tb_role_menus);
            $t_role_menus->updateOrInsert([
                'role_id' => $role_id,
                'menu_id' => $menu->id
            ], []);
        }
    }

    private function addSeedsRolePermissions($role_id, $permission_unique){
        $t_permissions = DB::table($this->tb_permissions);
        $permission = $t_permissions->where($permission_unique)->first();
        if(isset($permission)){
            $t_role_permissions = DB::table($this->tb_role_permissions);
            $t_role_permissions->updateOrInsert([
                'role_id' => $role_id,
                'permission_id' => $permission->id
            ], []);
        }
    }
}
