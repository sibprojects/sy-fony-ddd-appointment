<?php

namespace AcmeVet\Scheduling\Domain\Appointment;

use AcmeVet\Scheduling\Domain\Appointment\Exception\AppointmentLengthInvalid;
/*
 * This is the 'Aggregate Root' of the Appointment Bounded Context.
 *
 * All services in the Bounded Context call methods directly on the
 * Aggregate Root; they _do not_ call any methods on the other Entity classes,
 * nor do they instantiate any other class than the Aggregate Root.
 *
 */

class Appointment
{
    private const STANDARD_APPOINTMENT_LENGTH_IN_MINUTES = 15;

    private AppointmentId $appointmentId;
    private Pet $pet;
    private \DateTimeImmutable $appointmentTime;
    private int $appointmentLengthInMinutes;

    private function __construct(
        AppointmentId $appointmentId,
        Pet $pet,
        \DateTimeImmutable $appointmentTime,
        int $appointmentLengthInMinutes
    )
    {
        $this->appointmentId = $appointmentId;
        $this->pet = $pet;
        $this->appointmentTime = $appointmentTime;
        $this->appointmentLengthInMinutes = $appointmentLengthInMinutes;
    }

    public static function create(
        AppointmentId $appointmentId,
        Pet $pet,
        \DateTimeImmutable $appointmentTime,
        int $appointmentLengthInMinutes
    ): self
    {
        if (self::STANDARD_APPOINTMENT_LENGTH_IN_MINUTES > $appointmentLengthInMinutes) {
            throw new AppointmentLengthInvalid(
                sprintf("The minumum appointment length is %s minutes", self::STANDARD_APPOINTMENT_LENGTH_IN_MINUTES)
            );
        }

        $maxAppointmentLength = self::STANDARD_APPOINTMENT_LENGTH_IN_MINUTES * 2;

        if ($maxAppointmentLength < $appointmentLengthInMinutes) {
            throw new AppointmentLengthInvalid(
                sprintf("The maximum appointment length is %s minutes", $maxAppointmentLength)
            );
        }

        if (0 !== $appointmentLengthInMinutes % self::STANDARD_APPOINTMENT_LENGTH_IN_MINUTES) {
            throw new AppointmentLengthInvalid(
                sprintf("The appointment length must be a multiple of %s minutes", self::STANDARD_APPOINTMENT_LENGTH_IN_MINUTES)
            );
        }

        return new self($appointmentId, $pet, $appointmentTime, $appointmentLengthInMinutes);
    }

    public function getId(): AppointmentId
    {
        return $this->appointmentId;
    }

    public function getPet(): Pet
    {
        return $this->pet;
    }

    public function getStartTime(): \DateTimeImmutable
    {
        return $this->appointmentTime;
    }

    public function getLengthInMinutes(): int
    {
        return $this->appointmentLengthInMinutes;
    }
}