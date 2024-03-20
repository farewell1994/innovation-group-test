<?php

namespace App\Controller\Traits;

use App\Model\FormErrorResponseDTOFactory;
use Symfony\Component\Form\FormInterface;

trait FormErrorsResponseTrait
{
    public function getFormattedFormErrors(FormInterface $form): array
    {
        $result = [];

        foreach ($form->getErrors(true) as $error) {
            $result[] = FormErrorResponseDTOFactory::create(
                $error->getOrigin()->getName(),
                $error->getMessage()
            );
        }

        return $result;
    }
}
