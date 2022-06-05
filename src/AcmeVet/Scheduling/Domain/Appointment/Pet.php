<?php

namespace AcmeVet\Scheduling\Domain\Appointment;

class Pet
{
    private string $name;
    private string $ownerName;
    private string $contactNumber;

    private function __construct(string $name, string $ownerName, string $contactNumber)
    {
        $this->name = $name;
        $this->ownerName = $ownerName;
        $this->contactNumber = $contactNumber;
    }

    public static function create(string $name, string $ownerName, string $contactNumber)
    {
        return new self($name, $ownerName, $contactNumber);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOwnerName(): string
    {
        return $this->ownerName;
    }

    public function getContactNumber(): string
    {
        return $this->contactNumber;
    }
}