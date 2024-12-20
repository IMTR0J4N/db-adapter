<?php

namespace DBAdapter\MongoDB\Document;

use DBAdapter\Context\Class\AbstractDocument;
use MongoDB\BSON\ObjectId;

class BillingDocument extends AbstractDocument
{
    private ObjectId $_id;
    private ObjectId $contract_id;
    private float $amount;

    public function __construct(string $contract_id, float $amount)
    {
        $this->_id = new ObjectId();
        $this->contract_id = new ObjectId($contract_id);
        $this->amount = $amount;
    }

    public function setId(ObjectId $id): void
    {
        $this->_id = $id;
    }

    public function getId(): ObjectId
    {
        return $this->_id;
    }

    public function getContractId(): ObjectId
    {
        return $this->contract_id;
    }

    public function setContractId(ObjectId $contractId): void
    {
        $this->contract_id = $contractId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function bsonSerialize(): array
    {
        return [
            '_id' => $this->getId(),
            'contract_id' => $this->getContractId(),
            'amount' => $this->getAmount()
        ];
    }

    public function bsonUnserialize($data): void
    {
        $this->setId($data['_id']);
        $this->setContractId($data['contract_id']);
        $this->setAmount($data['amount']);
    }
}