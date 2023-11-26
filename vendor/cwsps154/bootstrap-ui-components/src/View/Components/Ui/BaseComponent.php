<?php
/**
 * PHP Version 8.*
 * Laravel Framework 9.* - 10.*
 *
 * @category BaseComponent
 *
 * @author CWSPS154 <codewithsps154@gmail.com>
 * @license MIT License https://opensource.org/licenses/MIT
 *
 * @link https://github.com/CWSPS154
 *
 * Date 31/03/23
 * */

namespace CWSPS154\BootstrapUiComponents\View\Components\Ui;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BaseComponent extends Component
{
    /**
     * @var string
     */
    protected string $template;

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Factory|Htmlable|Closure|string|Application
     */
    public function render(): View|Factory|Htmlable|Closure|string|Application
    {
        return view(config('buicomponents.package').'::'.$this->template);
    }
}
