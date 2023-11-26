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
 * Date 09/10/22
 * */

namespace CWSPS154\BootstrapUiComponents\View\Components\Ui;

class Textarea extends BaseInput
{
    /**
     * @var string
     */
    protected string $template = 'components.ui.textarea';

    /**
     * @return string
     */
    public function getPlugins(): string
    {
        $configPlugin = explode(' ', config('buicomponents.tinymce.plugins'));
        $optionPlugin = explode(' ', $this->attributes->get('plugins'));
        $merged_array = array_merge($configPlugin, $optionPlugin);
        $unique_array = array_diff($merged_array, array_intersect($configPlugin, $optionPlugin));

        return implode(' ', $unique_array);
    }

    /**
     * @return string
     */
    public function getToolbar(): string
    {
        $configToolbar = explode(' | ', config('buicomponents.tinymce.toolbar'));
        $optionToolbar = explode(' | ', $this->attributes->get('toolbar'));
        $merged_array = array_merge($optionToolbar, $configToolbar);
        $unique_array = array_diff($merged_array, array_intersect($configToolbar, $optionToolbar));

        return implode(' | ', $unique_array);
    }
}
