<?php

namespace DBConnector\MySQL;

use DBConnector\Context\Types\Repositories;
use DBConnector\MySQL\Adapter\MySQLAdapter;
use DBConnector\MySQL\Entity\Billing;
use DBConnector\MySQL\Entity\Contract;
use DBConnector\MySQL\Entity\Customer;
use DBConnector\MySQL\Entity\Vehicle;
use PDO;
use PDOException;

/**
 * Classe Repository
 *
 * Fournit des méthodes génériques pour interagir avec une base de données MySQL.
 * Permet de réaliser des opérations CRUD (Create, Read, Update, Delete) sur différentes entités.
 *
 * @package DBConnector\MySQL
 */
class Repository
{
    /**
     * @var Repositories Le type de repository (Billing, Contract, Customer, Vehicle).
     */
    private Repositories $repository;

    /**
     * @var PDO Instance de connexion PDO à la base de données MySQL.
     */
    private PDO $pdo;

    /**
     * @var string La classe de l'entité associée à ce repository.
     */
    private string $entityClass;

    /**
     * Constructeur de la classe Repository.
     *
     * Initialise le repository avec le type spécifié et configure la connexion à la base de données.
     *
     * @param Repositories $repository Le type de repository à utiliser.
     * @param array $authOptions Options d'authentification contenant les informations de connexion :
     *                           - host : Hôte de la base de données.
     *                           - port : Port de la base de données.
     *                           - db : Nom de la base de données.
     *                           - username : Nom d'utilisateur.
     *                           - password : Mot de passe.
     *
     * @throws \InvalidArgumentException Si le type de repository n'est pas pris en charge.
     */
    public function __construct(Repositories $repository, array $authOptions)
    {
        $this->repository = $repository;

        // Connexion via MySQLAdapter
        $this->pdo = MySQLAdapter::getAdapter()->retrieveConnection(
            $authOptions['host'],
            $authOptions['port'],
            $authOptions['database'],
            $authOptions['username'],
            $authOptions['password']
        );

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
     * Recherche un enregistrement par une clé et une valeur spécifiques.
     *
     * @param string $key La colonne à rechercher.
     * @param string $value La valeur à rechercher dans la colonne spécifiée.
     * @param array|null $options Options supplémentaires pour la requête (par exemple, 'limit').
     *
     * @return object|null Une instance de la classe d'entité correspondante ou null si aucun résultat trouvé.
     */
    public function findBy(string $key, string $value, ?array $options = null): ?object
    {
        $table = $this->repository->value;
        $limit = $options['limit'] ?? 1;
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE {$key} = :value LIMIT {$limit}");
        $stmt->execute(['value' => $value]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $this->hydrate($result) : null;
    }

    /**
     * Récupère tous les enregistrements de la table associée.
     *
     * @return array Tableau d'instances de la classe d'entité correspondante.
     */
    public function getAll(): array
    {
        $table = $this->repository->value;
        $stmt = $this->pdo->query("SELECT * FROM {$table}");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->hydrate($row), $results);
    }

    /**
     * Crée un nouvel enregistrement dans la table associée.
     *
     * @param Billing|Contract|Customer|Vehicle $data Instance de l'entité à insérer.
     * @param array|null $options Options supplémentaires pour l'insertion.
     *
     * @return bool Vrai si l'opération réussit, faux sinon.
     */
    public function create(Billing|Contract|Customer|Vehicle $data, ?array $options = null): bool
    {
        try {
            $table = $this->repository->value;
            $fields = array_keys(get_object_vars($data));
            $placeholders = array_map(fn($field) => ":{$field}", $fields);
            $sql = "INSERT INTO {$table} (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(get_object_vars($data));

            return true;
        } catch (PDOException $e) {
            error_log('Create operation failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Met à jour un ou plusieurs enregistrements dans la table associée.
     *
     * @param array $filter Critères de sélection des enregistrements à mettre à jour.
     * @param array $updateData Données à mettre à jour.
     * @param array|null $options Options supplémentaires pour la mise à jour.
     *
     * @return bool Vrai si l'opération réussit, faux sinon.
     */
    public function update(array $filter, array $updateData, ?array $options = null): bool
    {
        try {
            $table = $this->repository->value;
            $setClauses = [];
            foreach ($updateData as $field => $value) {
                $setClauses[] = "{$field} = :set_{$field}";
            }
            $setString = implode(', ', $setClauses);

            $whereClauses = [];
            foreach ($filter as $field => $value) {
                $whereClauses[] = "{$field} = :where_{$field}";
            }
            $whereString = implode(' AND ', $whereClauses);

            $sql = "UPDATE {$table} SET {$setString} WHERE {$whereString}";
            $stmt = $this->pdo->prepare($sql);

            // Préparer les paramètres
            $params = [];
            foreach ($updateData as $field => $value) {
                $params["set_{$field}"] = $value;
            }
            foreach ($filter as $field => $value) {
                $params["where_{$field}"] = $value;
            }

            $stmt->execute($params);

            return true;
        } catch (PDOException $e) {
            error_log('Update operation failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprime un enregistrement de la table associée par son identifiant.
     *
     * @param int $id Identifiant de l'enregistrement à supprimer.
     * @param array|null $options Options supplémentaires pour la suppression.
     *
     * @return bool Vrai si l'opération réussit, faux sinon.
     */
    public function delete(int $id, ?array $options = null): bool
    {
        try {
            $table = $this->repository->value;
            $stmt = $this->pdo->prepare("DELETE FROM {$table} WHERE id = :id");
            $stmt->execute(['id' => $id]);

            return true;
        } catch (PDOException $e) {
            error_log('Delete operation failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Hydrate un tableau de données en une instance de la classe d'entité correspondante.
     *
     * @param array $data Données à hydrater.
     *
     * @return object Instance de la classe d'entité correspondante.
     */
    private function hydrate(array $data): object
    {
        $class = $this->entityClass;
        $object = new $class();

        foreach ($data as $key => $value) {
            if (property_exists($object, $key)) {
                $object->$key = $value;
            }
        }

        return $object;
    }
}
