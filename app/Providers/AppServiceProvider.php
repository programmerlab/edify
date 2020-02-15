<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use Route;
use Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $controllers = [];

        foreach (Route::getRoutes()->getRoutes() as $route)
        {
            $action = $route->getAction();

            if (array_key_exists('controller', $action))
            {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                if(Str::contains($action['controller'],'@index')){
                    $step1 = str_replace('Modules\Admin\Http\Controllers','',$action['controller']);    
                    $step2 = str_replace("@index", '', $step1);
                    $step3 = str_replace("Controller", '', $step2);
                    
                    $notArr = ['Auth','Admin','Role','Compaint','ContactGroup','ArticleType','Article','Press','MonthlyReport',
                        'Program','Reason','Settings'];
                    if(in_array(ltrim($step3,'"\"'), $notArr))
                    {
                        continue;
                    }else{
                        $controllers[] = ltrim($step3,'"\"');
                    }
                }
                
            }
        } 
        
        View::share('controllers',$controllers);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
