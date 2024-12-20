<?php

namespace DBAdapter\Context\Class;

use DBAdapter\Context\Types\Adapters;
use DBAdapter\Context\Types\Repositories;
use DBAdapter\MongoDB\Repository as MongoDBRepository;
use DBAdapter\MySQL\Repository as MySQLRepository;
use MongoDB\BSON\ObjectId;
use MongoDB\Model\BSONDocument;
use Exception;

/**
 * Classe abstraite Service
 *
 * Fournit une base pour les services qui interagissent avec les repositories MySQL et MongoDB.
 *
 * @package DBAdapter\Context\Class
 */
abstract class AbstractService
{
    /**
     * @var Adapters Le type d'adapter utilisé (MySQL ou MongoDB).
     */
    protected Adapters $adapter;

    /**
     * @var MongoDBRepository|MySQLRepository Le repository utilisé par le service.
     */
    protected MongoDBRepository|MySQLRepository $repository;

    /**
     * @var array Options d'authentification pour la connexion à la base de données.
     */
    protected array $authOptions;

    /**
     * Constructeur de la classe Service.
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

    /**
     * Recherche un enregistrement par un champ et une valeur spécifiques.
     *
     * @param string      $field   Le champ de recherche.
     * @param mixed       $value   La valeur à rechercher.
     * @param array|null  $options Options supplémentaires pour la requête.
     *
     * @return object|null Instance de l'entité correspondante ou null si non trouvé.
     *
     * @throws Exception Si une erreur se produit lors de la recherche.
     */
    abstract public function findBy(string $field, mixed $value, ?array $options = null): object|null;

    /**
     * Récupère tous les enregistrements de la table associée.
     *
     * @return array Tableau d'instances de l'entité correspondante.
     *
     * @throws Exception Si une erreur se produit lors de la récupération.
     */
    abstract public function getAll(): array;

    /**
     * Crée un nouvel enregistrement dans la table associée.
     *
     * @param object      $data    Instance de l'entité à créer.
     * @param array|null  $options Options supplémentaires pour l'insertion.
     *
     * @return bool Vrai si l'opération réussit, faux sinon.
     *
     * @throws Exception Si une erreur se produit lors de la création.
     */
    abstract public function create(object $data, ?array $options = null): bool;

    /**
     * Met à jour un ou plusieurs enregistrements dans la table associée.
     *
     * @param array      $filter     Critères de sélection des enregistrements à mettre à jour.
     * @param array      $updateData Données de mise à jour.
     * @param array|null $options    Options supplémentaires pour la mise à jour.
     *
     * @return bool Vrai si l'opération réussit, faux sinon.
     *
     * @throws Exception Si une erreur se produit lors de la mise à jour.
     */
    abstract public function update(array $filter, array $updateData, ?array $options = null): bool;

    /**
     * Supprime un enregistrement de la table associée par son identifiant.
     *
     * @param ObjectId|string|int $id Identifiant de l'enregistrement à supprimer.
     * @param array|null          $options Options supplémentaires pour la suppression.
     *
     * @return bool Vrai si l'opération réussit, faux sinon.
     *
     * @throws Exception Si une erreur se produit lors de la suppression.
     */
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
            default => throw new \InvalidArgumentException("Adapter non pris en charge"),
        };

        return new $repositoryClass($repository, $authOptions);
    }
}
