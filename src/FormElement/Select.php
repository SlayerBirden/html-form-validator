<?php
/**
 * html-form-validator (https://github.com/xtreamwayz/html-form-validator)
 *
 * @see       https://github.com/xtreamwayz/html-form-validator for the canonical source repository
 * @copyright Copyright (c) 2016 Geert Eltink (https://xtreamwayz.com/)
 * @license   https://github.com/xtreamwayz/html-form-validator/blob/master/LICENSE.md MIT
 */

namespace Xtreamwayz\HTMLFormValidator\FormElement;

use Zend\Validator\Explode as ExplodeValidator;
use Zend\Validator\InArray as InArrayValidator;

class Select extends BaseFormElement
{
    protected function getValidators()
    {
        $validators = [];

        if ($this->node->hasAttribute('multiple')) {
            $validators[] = [
                'name'    => ExplodeValidator::class,
                'options' => [
                    'validator'      => $this->getInArrayValidator(),
                    'valueDelimiter' => null, // skip explode if only one value
                ],
            ];
        } else {
            $validators[] = $this->getInArrayValidator();
        }

        return $validators;
    }

    private function getInArrayValidator()
    {
        return [
            'name'    => InArrayValidator::class,
            'options' => [
                'haystack' => $this->getValueOptions(),
                'strict'   => false,
            ],
        ];
    }

    private function getValueOptions()
    {
        $haystack = [];

        /** @var \DOMElement $option */
        foreach ($this->node->getElementsByTagName('option') as $option) {
            $haystack[] = $option->getAttribute('value');
        }

        return $haystack;
    }
}
