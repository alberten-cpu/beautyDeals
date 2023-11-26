<?php

/**
 * PHP Version 8.1.11
 * Laravel Framework 9.43.0
 *
 * @category Component
 *
 * @author CWSPS154 <codewithsps154@gmail.com>
 * @license MIT License https://opensource.org/licenses/MIT
 *
 * @link https://github.com/CWSPS154
 *
 * Date 11/12/22
 * */

namespace App\View\Components\Admin\Ui;

use Helper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Menu extends Component
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $route;

    /**
     * @var string
     */
    public $icon;

    public $target;

    /**
     * @var bool|int
     */
    public $new;

    /**
     * @var int
     */
    public $count;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        string $route,
        string $icon,
        int $target = 0,
        int $new = 0,
        int $count = 0
    ) {
        $this->name = $name;
        $this->route = $route;
        $this->icon = $icon;
        $this->target = Helper::getTarget($target);
        $this->new = $new;
        $this->count = $count;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.admin.ui.menu');
    }
}
