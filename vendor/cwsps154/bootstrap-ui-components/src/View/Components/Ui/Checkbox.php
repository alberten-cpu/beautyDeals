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

class Checkbox extends BaseInput
{
    /**
     * @var string
     */
    protected string $template = 'components.ui.checkbox';

    /**
     * @var string|null
     */
    public ?string $class = 'form-check-input';

    /**
     * @var string
     */
    public string $type = 'checkbox';

    /**
     * @var string
     */
    public string $btFormClass = 'form-group form-check';

    /**
     * @var string|null
     */
    public ?string $labelClass = 'form-check-label';

    /**
     * @param $value
     * @return string|null
     */
    public function isChecked($value): ?string
    {
        return $value === $this->attributes->get('defaultValue') ? 'checked' : null;
    }

    /**
     * @return int|null
     */
    public function getArrayIndex(): ?int
    {
        $start = strpos($this->name, '[');
        $end = strpos($this->name, ']');
        if ($start !== false && $end !== false && $end > $start) {
            $index = substr($this->name, $start + 1, $end - $start - 1);
            if ($index) {
                return intval($index);
            } else {
                return 0;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function mergedName(): string
    {
        return $this->getArrayIndex() === 0 || $this->getArrayIndex() ? $this->getName().'.'.$this->getArrayIndex() : $this->getName();
    }
}
