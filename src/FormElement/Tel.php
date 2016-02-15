<?php

namespace Xtreamwayz\HTMLFormValidator\FormElement;

use Zend\Filter\StripNewlines;

class Tel extends AbstractFormElement
{
    /**
     * @inheritdoc
     */
    protected function attachDefaultFilters()
    {
        $this->attachFilterByName(StripNewlines::class);
    }

    /**
     * @inheritdoc
     */
    protected function attachDefaultValidators()
    {
        $this->attachValidatorByName('phonenumber', [
            'country' => $this->element->getAttribute('data-country'),
        ]);

        if ($this->element->hasAttribute('minlength') || $this->element->hasAttribute('maxlength')) {
            $this->attachValidatorByName('stringlength', [
                'min'      => $this->element->getAttribute('minlength') ?: 0,
                'max'      => $this->element->getAttribute('maxlength') ?: null,
            ]);
        }

        if ($this->element->hasAttribute('pattern')) {
            $this->attachValidatorByName('regex', [
                'pattern' => sprintf('/%s/', $this->element->getAttribute('pattern')),
            ]);
        }
    }
}
