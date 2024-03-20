<?php

namespace App\Model\DTO;

class FormErrorResponseDTO implements \JsonSerializable
{
    private string $origin;

    private string $message;

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): FormErrorResponseDTO
    {
        $this->origin = $origin;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): FormErrorResponseDTO
    {
        $this->message = $message;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'origin' => $this->getOrigin(),
            'message' => $this->getMessage(),
        ];
    }
}
