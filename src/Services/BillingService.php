<?php

namespace DBAdapter\Services;

use DBAdapter\Context\Class\AbstractService;
use DBAdapter\Context\Types\Adapters;
use DBAdapter\Context\Types\Repositories;
use DBAdapter\MySQL\Entity\BillingEntity as MySQLBilling;
use DBAdapter\MongoDB\Document\BillingDocument as MongoDBBilling;
use MongoDB\BSON\ObjectId;
use Exception;

/**
 * Classe BillingService
 *
 * Fournit des services pour gérer les opérations de facturation (Billing) en utilisant les repositories MySQL ou MongoDB.
 *
 * @package DBAdapter\Services
 */
class BillingService extends AbstractService
{
    /**
     * BillingService constructor.
     *
     * Initialise le service avec l'adapter spécifié et configure le repository pour Billing.
     *
     * @param Adapters $adapter      Le type d'adapter (MySQL ou MongoDB).
     * @param array    $authOptions  Options d'authentification pour la connexion à la base de données.
     */
    public function __construct(Adapters $adapter, array $authOptions)
    {
        parent::__construct($adapter, Repositories::BillingRepository, $authOptions);
    }

    public function getAdapter(): Adapters
    {
        return $this->adapter;
    }

    public function getAuthOptions(): array
    {
        return $this->authOptions;
    }

    /**
     * Recherche une facturation par un champ et une valeur spécifiques.
     *
     * @param string      $field   Le champ de recherche.
     * @param mixed       $value   La valeur à rechercher.
     * @param array|null  $options Options supplémentaires pour la requête.
     *
     * @return MySQLBilling|MongoDBBilling|null Instance de Billing ou null si non trouvé.
     *
     * @throws Exception Si une erreur se produit lors de la recherche.
     */
    public function findBy(string $field, mixed $value, ?array $options = null): MySQLBilling|MongoDBBilling|null
    {
        try {
            return $this->repository->findBy($field, $value, $options);
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la recherche : ' . $e->getMessage());
        }
    }

    /**
     * Récupère toutes les facturations.
     *
     * @return array Tableau d'instances de Billing.
     *
     * @throws Exception Si une erreur se produit lors de la récupération.
     */
    public function getAll(): array
    {
        try {
            return $this->repository->getAll();
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la récupération de toutes les facturations : ' . $e->getMessage());
        }
    }

    /**
     * Crée une nouvelle facturation.
     *
     * @param MySQLBilling|MongoDBBilling $data    Instance de Billing à créer.
     * @param array|null                   $options Options supplémentaires pour l'insertion.
     *
     * @return bool Vrai si l'opération réussit, faux sinon.
     *
     * @throws Exception Si une erreur se produit lors de la création.
     */
    public function create(object $data, ?array $options = null): bool
    {
        // Type casting pour garantir le type attendu
        if (!($data instanceof MySQLBilling || $data instanceof MongoDBBilling)) {
            throw new Exception('Données de facturation invalides.');
        }

        try {
            return $this->repository->create($data, $options ?? []);
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la création de la facturation : ' . $e->getMessage());
        }
    }

    /**
     * Met à jour une ou plusieurs facturations.
     *
     * @param array      $filter     Critères de sélection des facturations à mettre à jour.
     * @param array      $updateData Données de mise à jour.
     * @param array|null $options    Options supplémentaires pour la mise à jour.
     *
     * @return bool Vrai si l'opération réussit, faux sinon.
     *
     * @throws Exception Si une erreur se produit lors de la mise à jour.
     */
    public function update(array $filter, array $updateData, ?array $options = null): bool
    {
        try {
            return $this->repository->update($filter, $updateData, $options);
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la mise à jour de la facturation : ' . $e->getMessage());
        }
    }

    /**
     * Supprime une facturation par son identifiant.
     *
     * @param ObjectId|string|int $id Identifiant de la facturation à supprimer.
     * @param array|null          $options Options supplémentaires pour la suppression.
     *
     * @return bool Vrai si l'opération réussit, faux sinon.
     *
     * @throws Exception Si une erreur se produit lors de la suppression.
     */
    public function delete(ObjectId|string|int $id, ?array $options = null): bool
    {
        try {
            return $this->repository->delete($id, $options);
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la suppression de la facturation : ' . $e->getMessage());
        }
    }
}