<?php

namespace Xtreamwayz\HTMLFormValidator\FormElement;

use DOMElement;
use Zend\Filter\StripNewlines;
use Zend\InputFilter\InputInterface;

class Text extends AbstractFormElement
{
    /**
     * @inheritdoc
     */
    protected function attachDefaultValidators(InputInterface $input, DOMElement $element)
    {
        $input->getFilterChain()->attachByName(StripNewlines::class);

        if ($element->hasAttribute('maxlength')) {
            $this->attachValidatorByName($input, 'stringlength', [
                'max' => $element->getAttribute('maxlength'),
            ]);
        }

        if ($element->hasAttribute('pattern')) {
            $this->attachValidatorByName($input, 'regex', [
                'pattern' => sprintf('/%s/', $element->getAttribute('pattern')),
            ]);
        }
    }
}
