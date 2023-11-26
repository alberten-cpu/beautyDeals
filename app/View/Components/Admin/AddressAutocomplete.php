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

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddressAutocomplete extends Component
{
    /**
     * @var string
     */
    public $inputId;

    /**
     * @var object|null
     */
    public $editData;

    /**
     * @var string
     */
    public $relations;

    /**
     * @var false|mixed
     */
    public $noRelation;

    public bool $readonly;

    public bool $disable;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $inputId = null,
        object $editData = null,
        string $relations = 'defaultAddress',
        bool $noRelation = false,
        bool $readonly = false,
        bool $disable = false
    ) {
        $this->inputId = $inputId;
        $this->editData = $editData;
        $this->relations = $relations;
        $this->noRelation = $noRelation;
        $this->readonly = $readonly;
        $this->disable = $disable;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.admin.address-autocomplete');
    }
}
