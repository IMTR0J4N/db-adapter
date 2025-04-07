<?php

namespace DBAdapter\MongoDB\Document;

use DBAdapter\Context\Class\AbstractDocument;
use MongoDB\BSON\ObjectId;

class CustomerDocument extends AbstractDocument
{
    private ObjectId $id;
    private string $firstname;
    private string $lastname;
    private string $address;
    private string $email;
    private string $password;
    private string $driverLicenseNumber;

    public function __construct(string $firstname, string $lastname, string $address, string $email, string $password, string $driverLicenseNumber)
    {
        $this->id = new ObjectId();
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setAddress($address);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setDriverLicenseNumber($driverLicenseNumber);
    }

    public function getId(): ObjectId
    {
        return $this->id;
    }

    public function setId(ObjectId $id): void
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
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $this->password = $hashedPassword;
    }

    public function getDriverLicenseNumber(): string
    {
        return $this->driverLicenseNumber;
    }

    public function setDriverLicenseNumber(string $driverLicenseNumber): void
    {
        $this->driverLicenseNumber = $driverLicenseNumber;
    }

    public function bsonSerialize(): array
    {
        return [
            "_id" => $this->getId(),
            "firstname"=> $this->getFirstName(),
            "lastname"=> $this->getLastName(),
            "address"=> $this->getAddress(),
            "email"=> $this->getEmail(),
            "password"=> $this->getPassword(),
            "driverLicenseNumber"=> $this->getDriverLicenseNumber()
        ];
    }

    public function bsonUnserialize($data): void
    {
        $this->setId($data['_id']);
        $this->setFirstname($data['firstname']);
        $this->setLastname($data['lastname']);
        $this->setAddress($data['address']);
        $this->setEmail($data['email']);
        $this->setPassword($data['password']);
        $this->setDriverLicenseNumber($data['driverLicenseNumber']);
    }
}