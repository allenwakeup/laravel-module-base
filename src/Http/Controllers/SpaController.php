<?php

namespace Goodcatch\Modules\Base\Http\Controllers;

use App\Http\Controllers\SpaController as Controller;
use App\Http\Resources\Home\ConfigResource\ConfigResource;
use App\Services\ConfigService;

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

    public function index(){
        return view('base:index',$this->getViewContext());
    }

}