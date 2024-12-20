<?php

namespace DBAdapter\Context\Class;

use DBAdapter\Context\Types\Adapters;
use DBAdapter\Context\Types\Repositories;
use DBAdapter\Context\Interface\ServiceInterface;
use DBAdapter\MongoDB\Repository as MongoDBRepository;
use DBAdapter\MySQL\Repository as MySQLRepository;
use MongoDB\BSON\ObjectId;
use InvalidArgumentException;

/**
 * Classe abstraite AbstractService
 *
 * Fournit une base pour les services qui interagissent avec les repositories MySQL et MongoDB.
 *
 * @package DBAdapter\Context\Class
 */
abstract class AbstractService implements ServiceInterface
{
    protected Adapters $adapter;
    protected MongoDBRepository|MySQLRepository $repository;
    protected array $authOptions;

    /**
     * Constructeur de la classe AbstractService.
     *
     * Initialise le service avec l'adapter spécifié, le repository approprié et les options d'authentification.
     *
     * @param Adapters     $adapter     Le type d'adapter (MySQL ou MongoDB).
     * @param Repositories $repository  Le type de repository à utiliser (BillingRepository, etc.).
     * @param array        $authOptions Options d'authentification pour la connexion à la base de données.
     *
     * @throws \InvalidArgumentException Si le type de repository ou d'adapter n'est pas pris en charge.
     */
    public function __construct(Adapters $adapter, Repositories $repository, array $authOptions)
    {
        $this->adapter = $adapter;
        $this->repository = $this->retrieveRepository($repository, $authOptions);
        $this->authOptions = $authOptions;
    }

    abstract public function findBy(string $field, mixed $value, ?array $options = null): ?object;
    abstract public function getAll(): array;
    abstract public function create(object $data, ?array $options = null): bool;
    abstract public function update(array $filter, array $updateData, ?array $options = null): bool;
    abstract public function delete(ObjectId|string|int $id, ?array $options = null): bool;

    /**
     * Récupère une instance du repository approprié en fonction de l'adapter spécifié.
     *
     * @param Repositories $repository  Le type de repository à utiliser.
     * @param array        $authOptions Options d'authentification pour la connexion à la base de données.
     *
     * @return MySQLRepository|MongoDBRepository Instance du repository approprié.
     *
     * @throws \InvalidArgumentException Si le type de repository ou d'adapter n'est pas pris en charge.
     */
    private function retrieveRepository(Repositories $repository, array $authOptions): MySQLRepository|MongoDBRepository
    {
        $repositoryClass = match ($this->adapter) {
            Adapters::MySQL => MySQLRepository::class,
            Adapters::MongoDB => MongoDBRepository::class,
            default => throw new InvalidArgumentException("Adapter non pris en charge"),
        };

        return new $repositoryClass($repository, $authOptions);
    }
}
