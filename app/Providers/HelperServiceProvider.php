<?php
/**
 * Created by PhpStorm.
 * User: Victor Souto
 * Date: 24/01/2016
 * Time: 18:54
 */

namespace app\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider  extends ServiceProvider
{

    public function register()
    {
        foreach (glob(app_path().'/Helpers/*.php') as $filename){
            require_once($filename);
        }
    }

}