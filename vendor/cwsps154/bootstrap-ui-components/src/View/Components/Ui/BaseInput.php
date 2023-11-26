<?php
/**
 * PHP Version 8.*
 * Laravel Framework 9.* - 10.*
 *
 * @category BaseInputComponent
 *
 * @author CWSPS154 <codewithsps154@gmail.com>
 * @license MIT License https://opensource.org/licenses/MIT
 *
 * @link https://github.com/CWSPS154
 *
 * Date 01/04/23
 * */

namespace CWSPS154\BootstrapUiComponents\View\Components\Ui;

class BaseInput extends BaseComponent
{
    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string
     */
    public string $type = 'text';

    /**
     * @var string|null
     */
    public ?string $id;

    /**
     * @var string|null
     */
    public ?string $class = 'form-control';

    /**
     * @var string|null
     */
    public ?string $value;

    /**
     * @var bool
     */
    public bool $label = true;

    /**
     * @var string|null
     */
    public ?string $labelClass = 'form-label';

    /**
     * @var bool
     */
    public bool $btForm = true;

    /**
     * @var string
     */
    public string $btFormClass = 'form-group';

    /**
     * @var bool
     */
    public bool $error = true;

    /**
     * @var string|null
     */
    public ?string $requiredClass = 'text-danger';

    /**
     * @var string|null
     */
    public ?string $errorClass = 'invalid-feedback';

    /**
     * @var string|null
     */
    public ?string $help;

    /**
     * @var string|null
     */
    public ?string $helpClass = 'form-text text-muted';

    public ?string $placeholder;

    /**
     * Create a new component instance.
     *
     * @param  string|null  $name
     * @param  string|null  $type
     * @param  string|null  $id
     * @param  string|null  $class
     * @param  string|null  $value
     * @param  string|null  $placeholder
     * @param  string|null  $requiredClass
     * @param  bool  $label
     * @param  string|null  $labelClass
     * @param  bool  $btForm
     * @param  string|null  $btFormClass
     * @param  bool  $error
     * @param  string|null  $errorClass
     * @param  string|null  $help
     * @param  string|null  $helpClass
     * @param  string|null  $template
     */
    public function __construct(string $name = null,
                                string $type = null,
                                string $id = null,
                                string $class = null,
                                string $value = null,
                                string $placeholder = null,
                                string $requiredClass = null,
                                bool $label = true,
                                string $labelClass = null,
                                bool $btForm = true,
                                string $btFormClass = null,
                                bool $error = true,
                                string $errorClass = null,
                                string $help = null,
                                string $helpClass = null,
                                string $template = null,
    ) {
        $this->name = $name;
        $this->type = $type ?? $this->type ?? null;
        $this->id = $id ?? $this->getName();
        $this->class = $class ?? $this->class;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->requiredClass = $requiredClass ?? $this->requiredClass;
        $this->label = $label ?? $this->label;
        $this->labelClass = $labelClass ?? $this->labelClass;
        $this->btForm = $btForm ?? $this->btForm;
        $this->btFormClass = $btFormClass ?? $this->btFormClass;
        $this->error = $error ?? $this->error;
        $this->errorClass = $errorClass ?? $this->errorClass;
        $this->help = $help;
        $this->helpClass = $helpClass ?? $this->helpClass;
        $this->template = $template ?? $this->template;
        $this->setHidden();
    }

    /**
     * @return string|null
     */
    public function isHelp(): ?string
    {
        return $this->help ? 'aria-describedby="'.$this->name.'Help"' : null;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        $trimmedName = $this->name;
        if ($trimmedName && (str_contains($trimmedName, '[') || str_contains($trimmedName, ']'))) {
            $trimmedName = substr($trimmedName, 0, strpos($trimmedName, '['));
        }

        return $trimmedName;
    }

    public function setHidden()
    {
        if($this->type == 'hidden')
        {
            $this->btForm = false;
            $this->label = false;
            $this->error = false;
        }
    }
}
