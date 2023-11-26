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

namespace App\View\Components\Admin;

use Helper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TitleAndBreadcrumb extends Component
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var int
     */
    public $breadcrumbOn;

    /**
     * @var string
     */
    public $breadcrumbs;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title, int $breadcrumbOn = 1, string $breadcrumbs = null)
    {
        $this->title = $title;
        $this->breadcrumbOn = $breadcrumbOn;
        $this->breadcrumbs = Helper::convertJson($breadcrumbs);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.admin.title-and-breadcrumb');
    }
}
