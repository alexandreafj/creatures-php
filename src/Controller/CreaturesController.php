<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Dto\CreatureListParameterDto;
use Database\Database;

class CreaturesController 
{
  public function listCreatures(Request $request, Response $response): Response
  {
    $queryParams = $request->getQueryParams();
    $body = $response->getBody();
    try {
      $params = new CreatureListParameterDto($queryParams);
    } catch (\InvalidArgumentException $e) {
      $body->write(json_encode(['error' => $e->getMessage()]));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json')->withBody($body);
    }

    $db = new Database();

    $query = "SELECT * FROM creatures ORDER BY {$params->sortBy} {$params->sortOrder} LIMIT {$params->limit} OFFSET {$params->offset}";
    $creatures = $db->pdo->query($query)->fetchAll();

    if(empty($creatures)) {
      $body->write(json_encode(['error' => 'No creatures found']));
      return $response->withStatus(404)->withHeader('Content-Type', 'application/json')->withBody($body);
    }

    $body->write(json_encode($creatures));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json')->withBody($body);
  }

  public function createCreature(Request $request, Response $response): Response {
    $parsedBody = $request->getParsedBody();
    $query = 'INSERT INTO creatures (name, type, habitat, danger_level, created_at, updated_at) VALUES (:name, :type, :habitat, :danger_level, :created_at, :updated_at)';
    $db = new Database();
    $stmt = $db->pdo->prepare($query);
    $stmt->bindParam(':name', $parsedBody['name']);
    $stmt->bindParam(':type', $parsedBody['type']);
    $stmt->bindParam(':habitat', $parsedBody['habitat']);
    $stmt->bindParam(':danger_level', $parsedBody['danger_level']);
    $stmt->bindParam(':created_at', $parsedBody['created_at']);
    $stmt->bindParam(':updated_at', $parsedBody['updated_at']);
    $stmt->execute();
    $id = $db->pdo->lastInsertId();
    $query = 'SELECT * FROM creatures WHERE id = :id';
    $stmt = $db->pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $creature = $stmt->fetch();
    $body = $response->getBody();
    $body->write(json_encode($creature));
    return $response->withStatus(201)->withHeader('Content-Type', 'application/json')->withBody($body);
  }

  public function updateCreature(Request $request, Response $response): Response {
    $parsedBody = $request->getParsedBody();
    $id = $request->getAttribute('id');
    // $query = 'UPDATE creatures SET name = :name, type = :type, habitat = :habitat, danger_level = :danger_level, updated_at = :updated_at WHERE id = :id';
    // $db = new Database();
    // $stmt = $db->pdo->prepare($query);
    // $stmt->bindParam(':name', $parsedBody['name']);
    // $stmt->bindParam(':type', $parsedBody['type']);
    // $stmt->bindParam(':habitat', $parsedBody['habitat']);
    // $stmt->bindParam(':danger_level', $parsedBody['danger_level']);
    // $stmt->bindParam(':updated_at', $parsedBody['updated_at']);
    // $stmt->bindParam(':id', $id);
    // if($stmt->execute()) {
    //   return $response->withStatus(204);
    // } else {
    //   return $response->withStatus(500);
    // }
    return $response->withStatus(200);
  }

  // public function deleteCreature(Request $request, Response $response): Response


}