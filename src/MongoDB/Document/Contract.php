<?php

namespace DBConnector\MongoDB\Document;

use DBConnector\Context\Class\Document;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

class Contract extends Document
{
    private ObjectId $_id;
    private ObjectId $vehicle_id;
    private ObjectId $customer_id;
    private UTCDateTime $sign_at;
    private UTCDateTime $begin_at;
    private UTCDateTime $end_at;
    private UTCDateTime $returning_at;
    private float $price;

    public function __construct(ObjectId $vehicle_id, ObjectId $customer_id, UTCDateTime $sign_at, UTCDateTime $begin_at, UTCDateTime $end_at, UTCDateTime $returning_at, float $price) {
        $this->_id = new ObjectId();
        $this->vehicle_id = $vehicle_id;
        $this->customer_id = $customer_id;
        $this->sign_at = $sign_at;
        $this->begin_at = $begin_at;
        $this->end_at = $end_at;
        $this->returning_at = $returning_at;
        $this->price = $price;
    }

    public function getId(): ObjectId {
        return $this->_id;
    }

    public function getVehicleId(): ObjectId {
        return $this->vehicle_id;
    }

    public function getCustomerId(): ObjectId {
        return $this->customer_id;
    }

    public function getSignAt(): UTCDateTime {
        return $this->sign_at;
    }

    public function getBeginAt(): UTCDateTime {
        return $this->begin_at;
    }

    public function getEndAt(): UTCDateTime {
        return $this->end_at;
    }

    public function getReturningAt(): UTCDateTime {
        return $this->returning_at;
    }

    public function getPrice(): int {
        return $this->price;
    }

    public function setId(ObjectId $_id): void {
        $this->_id = $_id;
    }

    public function setVehicleId(ObjectId $vehicle_id): void {
        $this->vehicle_id = $vehicle_id;
    }

    public function setCustomerId(ObjectId $customer_id): void {
        $this->customer_id = $customer_id;
    }

    public function setSignAt(UTCDateTime $sign_at): void {
        $this->sign_at = $sign_at;
    }

    public function setBeginAt(UTCDateTime $begin_at): void {
        $this->begin_at = $begin_at;
    }

    public function setEndAt(UTCDateTime $end_at): void {
        $this->end_at = $end_at;
    }

    public function setReturningAt(UTCDateTime $returning_at): void {
        $this->returning_at = $returning_at;
    }

    public function setPrice(int $price): void {
        $this->price = $price;
    }

    public function bsonSerialize() {
        return [
            "_id" => $this->getId(),
            "vehicle_id" => $this->getVehicleId(),
            "customer_id" => $this->getCustomerId(),
            "sign_at" => $this->getSignAt(),
            "begin_at" => $this->getBeginAt(),
            "end_at" => $this->getEndAt(),
            "returning_at" => $this->getReturningAt(),
            "price" => $this->getPrice()
        ];
    }

    public function bsonUnserialize($data) {
        $this->setId($data["_id"]);
        $this->setVehicleId($data["vehicle_id"]);
        $this->setCustomerId($data["customer_id"]);
        $this->setSignAt($data["sign_at"]);
        $this->setReturningAt($data["returning_at"]);
        $this->setPrice($data["price"]);
    }
}