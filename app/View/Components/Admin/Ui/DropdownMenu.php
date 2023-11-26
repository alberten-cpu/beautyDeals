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

class DropdownMenu extends Component
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var string
     */
    public $menus;

    /**
     * Create a new component instance.
     */
    public function __construct(string $name, string $icon, string $menus)
    {
        $this->name = $name;
        $this->icon = $icon;
        $this->menus = Helper::convertJson($menus);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.admin.ui.dropdown-menu');
    }
}
