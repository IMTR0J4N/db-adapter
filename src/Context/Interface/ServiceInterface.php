<?php

namespace DBAdapter\Services;

use MongoDB\BSON\ObjectId;
use Exception;

/**
 * Interface ServiceInterface
 *
 * Définit les méthodes communes à tous les services.
 */
interface ServiceInterface
{
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
    public function findBy(string $field, mixed $value, ?array $options = null): ?object;

    /**
     * Récupère tous les enregistrements de la table associée.
     *
     * @return array Tableau d'instances de l'entité correspondante.
     *
     * @throws Exception Si une erreur se produit lors de la récupération.
     */
    public function getAll(): array;

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
    public function create(object $data, ?array $options = null): bool;

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
    public function update(array $filter, array $updateData, ?array $options = null): bool;

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
    public function delete(ObjectId|string|int $id, ?array $options = null): bool;
}
