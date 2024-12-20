<?php

namespace DBConnector\MongoDB;

use DBConnector\Context\Types\Repositories;
use DBConnector\MongoDB\Adapter\MongoDBAdapter;
use DBConnector\MongoDB\Document\Billing;
use DBConnector\MongoDB\Document\Contract;
use DBConnector\MongoDB\Document\Customer;
use DBConnector\MongoDB\Document\Vehicle;
use MongoDB\BSON\ObjectId;
use MongoDB\Database;

class Repository
{
    private Repositories $repository;
    private Database $database;
    private string $entityClass;

    public function __construct(Repositories $repository, array $authOptions)
    {
        $this->repository = $repository;
        $this->database = MongoDBAdapter::getAdapter()
            ->retrieveConnection($authOptions["uri"])
            ->selectDatabase($authOptions["database"]);

        // Mapping du repository vers une classe spécifique
        $this->entityClass = match ($repository) {
            Repositories::BillingRepository => Billing::class,
            Repositories::ContractRepository => Contract::class,
            Repositories::CustomerRepository => Customer::class,
            Repositories::VehicleRepository => Vehicle::class,
            default => throw new \InvalidArgumentException("Repository non pris en charge"),
        };
    }

    /**
     * Trouve un document par une clé et une valeur.
     *
     * @param string $key La clé de recherche.
     * @param string $value La valeur de recherche.
     * @param array|null $options Options supplémentaires.
     * @return object|null Instance de la classe correspondante ou null.
     */
    public function findBy(string $key, string $value, ?array $options = null): ?object
    {
        $collection = $this->database->selectCollection($this->repository->value);
        
        // Définir le typeMap pour hydrater automatiquement en instance de classe
        $options['typeMap'] = [
            'document' => $this->entityClass,
            'root' => 'array',
        ];
        
        $document = $collection->findOne([$key => $value], $options);

        return $document;
    }

    /**
     * Récupère tous les documents de la collection.
     *
     * @return array Tableau d'instances de la classe correspondante.
     */
    public function getAll(): array
    {
        $collection = $this->database->selectCollection($this->repository->value);
        
        // Définir le typeMap pour hydrater automatiquement en instances de classe
        $options['typeMap'] = [
            'document' => $this->entityClass,
            'root' => 'array',
        ];
        
        $documents = $collection->find([], $options);

        return $documents->toArray();
    }

    /**
     * Crée un nouveau document dans la collection.
     *
     * @param Billing|Contract|Customer|Vehicle $data Instance de la classe correspondante.
     * @param array|null $options Options supplémentaires.
     * @return bool Succès de l'opération.
     */
    public function create(Billing|Contract|Customer|Vehicle $data, ?array $options = null): bool
    {
        try {
            $collection = $this->database->selectCollection($this->repository->value);
            $collection->insertOne($data, $options ?? []);

            return true;
        } catch (\Exception $e) {
            error_log('Create operation failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Met à jour un document dans la collection.
     *
     * @param array $filter Filtre de recherche.
     * @param array $updateData Données de mise à jour.
     * @param array|null $options Options supplémentaires.
     * @return bool Succès de l'opération.
     */
    public function update(array $filter, array $updateData, ?array $options = null): bool
    {
        try {
            $collection = $this->database->selectCollection($this->repository->value);
            $collection->updateOne($filter, ['$set' => $updateData], $options ?? []);

            return true;
        } catch (\Exception $e) {
            error_log('Update operation failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprime un document de la collection.
     *
     * @param ObjectId $id Identifiant du document à supprimer.
     * @param array|null $options Options supplémentaires.
     * @return bool Succès de l'opération.
     */
    public function delete(ObjectId $id, ?array $options = null): bool
    {
        try {
            $collection = $this->database->selectCollection($this->repository->value);
            $collection->deleteOne(['_id' => $id], $options ?? []);

            return true;
        } catch (\Exception $e) {
            error_log('Delete operation failed: ' . $e->getMessage());
            return false;
        }
    }
}
