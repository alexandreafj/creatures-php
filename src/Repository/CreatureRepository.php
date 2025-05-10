<?php

namespace App\Repository;

use App\Dto\CreatureDTO;
use App\Dto\CreatureListParameterDto;
use Database\Database;

class CreatureRepository
{
    private $db = null;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Retrieves creatures from the database based on the provided filtering parameters.
     *
     * @param CreatureListParameterDto $params The filtering and pagination parameters for retrieving creatures.
     * - search: A string to filter creatures by name (partial match).
     * - habitat: The habitat to filter creatures by.
     * - minDangerLevel: The minimum danger level to filter creatures.
     * - type: The type of creatures to filter.
     * - limit: The number of records to retrieve.
     * - offset: The starting point for the records to retrieve.
     *
     * @return array An array of creatures with the retrieved fields: id, name, type, habitat, danger_level, and description.
     *
     * @throws \Exception If the query execution fails or an error occurs during data retrieval.
     */
    public function getCreatures(CreatureListParameterDto $params): array
    {
        $query = "SELECT id, name, type, habitat, danger_level, description FROM creatures";
        $conditions = [];
        $bindings = [];
        try {
            if (!empty($params->search)) {
                $conditions[] = "name LIKE ?";
                $bindings[] = "%{$params->search}%";
            }

            if (!empty($params->habitat)) {
                $conditions[] = "habitat = ?";
                $bindings[] = $params->habitat;
            }

            if (!empty($params->minDangerLevel)) {
                $conditions[] = "danger_level >= ?";
                $bindings[] = $params->minDangerLevel;
            }

            if (!empty($params->type)) {
                $conditions[] = "type = ?";
                $bindings[] = $params->type;
            }

            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }

            $query .= " LIMIT ?";
            $bindings[] = (int)$params->limit;

            $query .= " OFFSET ?";
            $bindings[] = (int)$params->offset;

            error_log("Preparing Creatures Query: " . $query);
            error_log("Query Bindings: " . print_r($bindings, true));
            error_log("Query Bindings: " . print_r($conditions, true));

            $stmt = $this->db->pdo->prepare($query);
            $stmt->execute($bindings);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            $debugInfo = [
                'query_template' => $query ?? 'Query not built',
                'bindings' => isset($bindings) ? print_r($bindings, true) : 'Bindings not set',
                'error' => $e->getMessage()
            ];
            error_log("Failed to get creatures: " . print_r($debugInfo, true));
            throw new \Exception("Failed to get creatures: {$e->getMessage()}");
        }
    }

    /**
     * @param array $body The data for the creature to insert. Should include keys such as 'name', 'type', 'habitat', 'danger_level', and 'description'.
     * @return void
     * @throws \Exception When database insertion fails.
     */
    public function create(array $body): void
    {
        $query = 'INSERT INTO creatures (name, type, habitat, danger_level, description, created_at, updated_at) ';
        try {
            $bindings = [];

            if (!empty($body['name'])) {
                $bindings[] = $body['name'];
            }

            if (!empty($body['type'])) {
                $bindings[] = $body['type'];
            }

            if (!empty($body['habitat'])) {
                $bindings[] = $body['habitat'];
            }

            if (!empty($body['danger_level'])) {
                $bindings[] = $body['danger_level'];
            }

            if (!empty($body['description'])) {
                $bindings[] = $body['description'];
            }

            $bindings[] = Date("Y:m:d H:i:s");
            $bindings[] = Date("Y:m:d H:i:s");

            error_log("Preparing Creatures Query: " . $query);
            error_log("Query Bindings: " . print_r($bindings, true));


            $query .= "VALUES (";
            for ($i = 0; $i < count($bindings); $i++) {
                $query .= "?,";
            }
            $query = substr($query, 0, -1);
            $query .= ")";

            error_log("Final Query: " . $query);

            $stmt = $this->db->pdo->prepare($query);
            $stmt->execute($bindings);
        } catch (\PDOException $e) {
            $debugInfo = [
                'query_template' => $query ?? 'Query not built',
                'bindings' => isset($bindings) ? print_r($bindings, true) : 'Bindings not set',
                'error' => $e->getMessage()
            ];
            error_log("Failed to create creature: " . print_r($debugInfo, true));
            throw new \Exception("Failed to create creature: {$e->getMessage()}");
        }
    }

    /**
     * @return array Returns an associative array containing the last creature id. Empty if none found.
     * @throws \Exception When database query fails
     */
    public function getLastById(): array
    {
        $query = 'SELECT id FROM creatures ORDER BY id DESC LIMIT 1';
        try {
            $stmt = $this->db->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            $debugInfo = [
                'query_template' => $query ?? 'Query not built',
            ];
            error_log("Failed to get last creature id: " . print_r($debugInfo, true));
            throw new \Exception("Failed to get last creature id: {$e->getMessage()}");
        }
    }

    /**
     * Updates the details of a specific creature in the database.
     *
     * @param int $id The ID of the creature to update. Must be greater than 0.
     * @param array $body An associative array containing the fields to update.
     *                    Valid keys include 'name', 'type', 'habitat', and 'danger_level'.
     * @return void
     * @throws \InvalidArgumentException When the provided creature ID is invalid.
     * @throws \Exception When database update operation fails.
     */
    public function update(int $id, array $body): void
    {
        $query = 'UPDATE creatures SET name = :name, type = :type, habitat = :habitat, danger_level = :danger_level, updated_at = :updated_at WHERE id = :id';
        try {
            $conditions = [];
            $bindings = [];

            if ($id <= 0) {
                throw new \InvalidArgumentException("Invalid creature id: {$id}");
            }

            if (!empty($body['name'])) {
                $conditions[] = "name = ?";
                $bindings[] = $body['name'];
            }

            if (!empty($body['type'])) {
                $conditions[] = "type = ?";
                $bindings[] = $body['type'];
            }

            if (!empty($body['habitat'])) {
                $conditions[] = "habitat = ?";
                $bindings[] = $body['habitat'];
            }

            if (!empty($body['danger_level'])) {
                $conditions[] = "danger_level = ?";
                $bindings[] = $body['danger_level'];
            }

            $conditions[] = "updated_at = ?";
            $bindings[] = Date("Y:m:d H:i:s");;

            $query .= " SET " . implode(", ", $conditions);
            $query .= " WHERE id = :id";
            $bindings[] = $id;

            error_log("Preparing Creatures Query: " . $query);
            error_log("Query Bindings: " . print_r($bindings, true));

            $stmt = $this->db->pdo->prepare($query);
            $stmt->execute($bindings);
        } catch (\PDOException $e) {
            $debugInfo = [
                'query_template' => $query ?? 'Query not built',
                'bindings' => isset($bindings) ? print_r($bindings, true) : 'Bindings not set',
                'error' => $e->getMessage()
            ];
            error_log("Failed to update creature: " . print_r($debugInfo, true));
            throw new \Exception("Failed to update creature: {$e->getMessage()}");
        }
    }

    /**
     * Deletes a creature by its ID.
     *
     * @param int $id The ID of the creature to delete. Must be greater than 0.
     * @return void
     * @throws \InvalidArgumentException If the provided ID is invalid (less than or equal to 0).
     * @throws \Exception When the database query fails.
     */
    public function delete(int $id): void
    {
        $query = 'DELETE FROM creatures WHERE id = :id';
        try {
            $bindings = [];
            if ($id <= 0) {
                throw new \InvalidArgumentException("Invalid creature id: {$id}");
            }

            $bindings[] = $id;
            error_log("Preparing Creatures Query: " . $query);

            $stmt = $this->db->pdo->prepare($query);
            $stmt->execute($bindings);
        } catch (\PDOException $e) {
            $debugInfo = [
                'query_template' => $query ?? 'Query not built',
                'bindings' => isset($bindings) ? print_r($bindings, true) : 'Bindings not set',
                'error' => $e->getMessage()
            ];
            error_log("Failed to delete creature: " . print_r($debugInfo, true));
            throw new \Exception("Failed to delete creature: {$e->getMessage()}");
        }
    }
}