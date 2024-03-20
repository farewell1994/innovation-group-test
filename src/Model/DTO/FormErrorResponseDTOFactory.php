<?php

namespace App\Model\DTO;

class FormErrorResponseDTOFactory
{
    public static function init(string $origin, string $message): FormErrorResponseDTO
    {
        return (new FormErrorResponseDTO())
            ->setOrigin($origin)
            ->setMessage($message);
    }
}
