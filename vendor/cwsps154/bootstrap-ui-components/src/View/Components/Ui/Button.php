<?php

/**
 * PHP Version 8.*
 * Laravel Framework 9.* - 10.*
 *
 * @category Component
 *
 * @author CWSPS154 <codewithsps154@gmail.com>
 * @license MIT License https://opensource.org/licenses/MIT
 *
 * @link https://github.com/CWSPS154
 *
 * Date 08/10/22
 * */

namespace CWSPS154\BootstrapUiComponents\View\Components\Ui;

class Button extends BaseComponent
{
    /**
     * @var string
     */
    protected string $template = 'components.ui.button';

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $id;

    /**
     * @var string|null
     */
    public ?string $class = 'btn btn-primary';

    /**
     * @var string|null
     */
    public ?string $type = 'button';

    /**
     * Create a new component instance.
     *
     * @param  string|null  $name
     * @param  string|null  $id
     * @param  string|null  $class
     * @param  string|null  $type
     */
    public function __construct(string $name = null,
                                string $id = null,
                                string $class = null,
                                string $type = null,
                                string $template = null
    ) {
        $this->name = $name;
        $this->id = $id ?? $name ?? null;
        $this->class = $class ?? $this->class;
        $this->type = $type ?? $this->type;
        $this->template = $template ?? $this->template;
    }
}
