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

class Textarea extends Component
{
    /**
     * @var string
     */
    public $label;

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
    public $placeholder;

    /**
     * @var bool
     */
    public $required;

    /**
     * @var string|null
     */
    public $value;

    /**
     * @var string|null
     */
    public $addClass;

    /**
     * @var bool
     */
    public $readonly;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $label,
        string $name,
        string $id,
        string $value = null,
        string $placeholder = '',
        bool $required = false,
        string $addClass = null,
        bool $readonly = false
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->value = $value;
        $this->addClass = $addClass;
        $this->readonly = $readonly;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.admin.ui.textarea');
    }
}
