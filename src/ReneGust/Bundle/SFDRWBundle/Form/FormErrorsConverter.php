<?php

namespace ReneGust\Bundle\SFDRWBundle\Form;

use Symfony\Component\Form\FormInterface;

/** convert form errors to a simple array */
class FormErrorsConverter {

    /**
     * @param FormInterface $form
     * @return array
     */
    public static function getErrorsFromForm(FormInterface $form) {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = self::getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }
}
