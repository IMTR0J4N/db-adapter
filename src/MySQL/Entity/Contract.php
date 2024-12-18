<?php

namespace DBConnector\MySQL\Entity;

use DateTime;

class Contract
{
    private string $_id;
    private string $vehicle_id;
    private string $customer_id;
    private DateTime $sign_at;
    private DateTime $begin_at;
    private DateTime $end_at;
    private DateTime $returning_at;
    private float $price;

    public function __construct(string $vehicle_id, string $customer_id, DateTime $sign_at, DateTime $begin_at, DateTime $end_at, DateTime $returning_at, float $price) {
        $this->_id = uniqid();
        $this->vehicle_id = $vehicle_id;
        $this->customer_id = $customer_id;
        $this->sign_at = $sign_at;
        $this->begin_at = $begin_at;
        $this->end_at = $end_at;
        $this->returning_at = $returning_at;
        $this->price = $price;
    }

    public function getId(): string {
        return $this->_id;
    }

    public function getVehicleId(): string {
        return $this->vehicle_id;
    }

    public function getCustomerId(): string {
        return $this->customer_id;
    }

    public function getSignAt(): DateTime {
        return $this->sign_at;
    }

    public function getBeginAt(): DateTime {
        return $this->begin_at;
    }

    public function getEndAt(): DateTime {
        return $this->end_at;
    }

    public function getReturningAt(): DateTime {
        return $this->returning_at;
    }

    public function getPrice(): int {
        return $this->price;
    }

    public function setId(string $_id): void {
        $this->_id = $_id;
    }

    public function setVehicleId(string $vehicle_id): void {
        $this->vehicle_id = $vehicle_id;
    }

    public function setCustomerId(string $customer_id): void {
        $this->customer_id = $customer_id;
    }

    public function setSignAt(DateTime $sign_at): void {
        $this->sign_at = $sign_at;
    }

    public function setBeginAt(DateTime $begin_at): void {
        $this->begin_at = $begin_at;
    }

    public function setEndAt(DateTime $end_at): void {
        $this->end_at = $end_at;
    }

    public function setReturningAt(DateTime $returning_at): void {
        $this->returning_at = $returning_at;
    }

    public function setPrice(int $price): void {
        $this->price = $price;
    }
}