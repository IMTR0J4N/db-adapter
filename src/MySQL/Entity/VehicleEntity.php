<?php

namespace DBAdapter\MySQL\Entity;

class VehicleEntity
{
    private string $_id;
    private string $model;
    private string $brand;
    private string $license_plate;
    private string $informations;
    private int $kilometers;

    public function __construct(string $model, string $brand, string $license_plate, string $informations, int $kilometers)
    {
        $this->_id = uniqid();
        $this->model = $model;
        $this->brand = $brand;
        $this->license_plate = $license_plate;
        $this->informations = $informations;
        $this->kilometers = $kilometers;
    }

    public function getId(): string
    {
        return $this->_id;
    }

    public function setId(string $id): void
    {
        $this->_id = $id;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getLicensePlate(): string
    {
        return $this->license_plate;
    }

    public function setLicensePlate(string $license_plate): void
    {
        $this->license_plate = $license_plate;
    }

    public function getInformations(): string
    {
        return $this->informations;
    }

    public function setInformations(string $informations): void
    {
        $this->informations = $informations;
    }

    public function getKilometers(): int
    {
        return $this->kilometers;
    }

    public function setKilometers(int $kilometers): void
    {
        $this->kilometers = $kilometers;
    }
}