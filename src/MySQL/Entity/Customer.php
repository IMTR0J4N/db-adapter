<?php

namespace DBConnector\MySQL\Entity;

class Customer
{
    private string $id;
    private string $firstname;
    private string $lastname;
    private string $address;
    private string $email;
    private string $password;
    private string $driverLicenseNumber;

    public function __construct(string $firstname, string $lastname, string $address, string $email, string $password, string $driverLicenseNumber)
    {
        $this->id = uniqid();
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->address = $address;
        $this->email = $email;
        $this->password = $password;
        $this->driverLicenseNumber = $driverLicenseNumber;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getDriverLicenseNumber(): string
    {
        return $this->driverLicenseNumber;
    }

    public function setDriverLicenseNumber(string $driverLicenseNumber): void
    {
        $this->driverLicenseNumber = $driverLicenseNumber;
    }
}