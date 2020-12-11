<?php
namespace Gowd\FileManager;
use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider{

    public function register()
    {
        $this->app->bind('filemanager',function (){
            return new FileManager;
        });

         $this->mergeConfigFrom(__DIR__ . '/Config/FileManager.php','FileManager');

    }
    public function boot(){
        //require  __DIR__.'\Http\routes.php';
        require __DIR__.'/Http/routes.php';
//        var_dump('route');die();
    }
}
