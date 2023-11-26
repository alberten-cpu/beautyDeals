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
 * Date 07/04/23
 * */

namespace CWSPS154\BootstrapUiComponents\View\Components\Ui;

class CropImage extends BaseInput
{
    /**
     * @var string
     */
    protected string $template = 'components.ui.crop-image';

        /**
     * @var string|null
     */
    public ?string $class = 'img-fluid';
}
