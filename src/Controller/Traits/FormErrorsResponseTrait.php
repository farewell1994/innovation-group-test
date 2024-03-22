<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use App\Model\DTO\FormErrorResponseDTOFactory;
use Symfony\Component\Form\FormInterface;

trait FormErrorsResponseTrait
{
    public function getFormattedFormErrors(FormInterface $form): array
    {
        $result = [];

        foreach ($form->getErrors(true) as $error) {
            $result[] = FormErrorResponseDTOFactory::init(
                $error->getOrigin()->getName(),
                $error->getMessage()
            );
        }

        return $result;
    }
}
