<?php

/**
 * PHP Version 8.*
 * Laravel Framework 9.* - 10.*
 *
 * @category Service Provider
 *
 * @author CWSPS154 <codewithsps154@gmail.com>
 * @license MIT License https://opensource.org/licenses/MIT
 *
 * @link https://github.com/CWSPS154
 *
 * Date 05/10/22
 * */

namespace CWSPS154\BootstrapUiComponents;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BootstrapUiComponentsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/buicomponents.php', 'buicomponents');
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views/', 'bootstrap-ui-components');
        Blade::componentNamespace('CWSPS154\\BootstrapUiComponents\\View\\Components', 'buicomponents');
        $this->publishes([__DIR__.'/config/buicomponents.php' => config_path('buicomponents.php')], 'config');
        $this->publishes([__DIR__.'/resources/views/components/ui' => resource_path('views/vendor/bootstrap-ui-components/components/ui')], 'components');
        $this->publishes([__DIR__.'/public/bootstrap-ui-components/' => public_path('/vendor/bootstrap-ui-components')], 'public');
    }
}
