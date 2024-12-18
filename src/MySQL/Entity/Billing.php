<?php

namespace DBConnector\MySQL\Entity;

class Billing
{
    private string $_id;
    private string $contract_id;
    private float $amount;

    public function __construct(string $contract_id, float $amount)
    {
        $this->_id = uniqid();
        $this->contract_id = $contract_id;
        $this->amount = $amount;
    }

    public function setId(string $id): void
    {
        $this->_id = $id;
    }

    public function getId(): string
    {
        return $this->_id;
    }

    public function getContractId(): string
    {
        return $this->contract_id;
    }

    public function setContractId(string $contractId): void
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
}