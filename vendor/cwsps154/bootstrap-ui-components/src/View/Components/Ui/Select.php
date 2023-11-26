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

class Select extends BaseInput
{
    protected string $template = 'components.ui.select';

    /**
     * @return mixed
     */
    public function getOption(): mixed
    {
        return $this->attributes->get('options');
    }

    /**
     * @param $value
     * @return string
     */
    public function getValue($value): string
    {
        if (! is_array($value)) {
            $value = explode(',', $value);
        }

        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
