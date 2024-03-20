<?php

namespace App\Model;

class FormErrorResponseDTOFactory
{
    public static function create(string $origin, string $message): FormErrorResponseDTO
    {
        return (new FormErrorResponseDTO())
            ->setOrigin($origin)
            ->setMessage($message);
    }
}
