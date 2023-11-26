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

class Form extends BaseComponent
{
    /**
     * @var string
     */
    protected string $template = 'components.ui.form';

    /**
     * @var string
     */
    public string $method;

    /**
     * @var bool
     */
    public bool $update;

    /**
     * @var bool
     */
    public bool $delete;

    /**
     * Create a new component instance.
     *
     * @param string $method
     * @param bool $update
     * @param bool $delete
     * @param string|null $template
     */
    public function __construct(string $method = 'GET',
                                bool $update = false,
                                bool $delete = false,
                                string $template = null
    ) {
        $this->method = $method;
        $this->update = $update;
        $this->delete = $delete;
        $this->template = $template ?? $this->template;
    }
}
