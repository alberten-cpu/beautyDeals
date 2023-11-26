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

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string|null
     */
    public $addClass;

    /**
     * @var string|null
     */
    public $placeholder;

    /**
     * @var bool
     */
    public $autocomplete;

    /**
     * @var bool
     */
    public $required;

    /**
     * @var bool
     */
    public $disable;

    /**
     * @var bool
     */
    public $readonly;

    /**
     * @var mixed|null
     */
    public $value;

    /**
     * @var string|null
     */
    public $other;

    /**
     * @var string|null
     */
    public $formGroupClass;
    /**
     * @var bool
     */
    public bool $multiple;

    /**
     * Create a new component instance.
     *
     * @param  null  $value
     */
    public function __construct(
        string $label,
        string $type,
        string $name,
        string $id,
        $value = null,
        string $other = null,
        string $addClass = null,
        string $formGroupClass = null,
        string $placeholder = null,
        bool $required = false,
        bool $readonly = false,
        bool $disable = false,
        bool $autocomplete = false,
        bool $multiple = false
    ) {
        $this->label = $label;
        $this->type = $type;
        $this->name = $name;
        $this->id = $id;
        $this->value = $value;
        $this->other = $other;
        $this->addClass = $addClass;
        $this->formGroupClass = $formGroupClass;
        $this->placeholder = null;
        $this->required = $required;
        $this->readonly = $readonly;
        $this->disable = $disable;
        $this->autocomplete = $autocomplete;
        $this->multiple = $multiple;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.admin.ui.input');
    }
}
