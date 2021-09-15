<?php

namespace Goodcatch\Modules\Base\Http\Controllers;

use App\Http\Controllers\SpaController as Controller;
use App\Http\Resources\Home\ConfigResource\ConfigResource;
use App\Services\ConfigService;
use Illuminate\Support\Facades\View;

class SpaController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        View::share('goodcatch', 'Goodcatch Modules');
    }

    protected function getViewContext(ConfigService $config_service){
        return $data = ConfigResource::make($config_service->getFormatConfig())->resolve();
    }

    protected function moduleIndex(array $view_content){
        return null;
    }

    public function index(ConfigService $config_service){
        $view_context = $this->getViewContext($config_service);
        $module_view = $this->moduleIndex($view_context);
        if(is_null($module_view)){
            return view('base::index', $view_context);
        }else{
            return $module_view;
        }
    }

}