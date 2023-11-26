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

class Radio extends Checkbox
{
    /**
     * @var string
     */
    protected string $template = 'components.ui.radio';

    /**
     * @var string
     */
    public string $type = 'radio';
}
