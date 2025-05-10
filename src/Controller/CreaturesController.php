<?php

namespace App\Controller;

use App\Repository\CreatureRepository;
use App\Util\HttpStatusCodes;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Dto\CreatureListParameterDto;
use Database\Database;

class CreaturesController 
{
    private $creatureRepository;
    public function __construct() {
        $this->creatureRepository = new CreatureRepository();
    }

    /**
     * @throws \Exception
     */
    public function listCreatures(Request $request, Response $response): Response
  {
    $queryParams = $request->getQueryParams();
    $body = $response->getBody();
    try {
      $params = new CreatureListParameterDto($queryParams);
    } catch (\InvalidArgumentException $e) {
      $body->write(json_encode(['error' => $e->getMessage()]));
      return $response->withStatus(HttpStatusCodes::BAD_REQUEST)->withHeader('Content-Type', 'application/json')->withBody($body);
    }

    $creatures = $this->creatureRepository->getCreatures($params);

    if(empty($creatures)) {
      $body->write(json_encode(['error' => 'No creatures found']));
      return $response->withStatus(HttpStatusCodes::OK)->withHeader('Content-Type', 'application/json')->withBody($body);
    }

    $body->write(json_encode($creatures));
    return $response->withStatus(HttpStatusCodes::OK)->withHeader('Content-Type', 'application/json')->withBody($body);
  }

  public function createCreature(Request $request, Response $response): Response {
    $parsedBody = $request->getParsedBody();
    $this->creatureRepository->create($parsedBody);
    $creature = $this->creatureRepository->getLastById();
    $body = $response->getBody();
    $body->write(json_encode($creature));
    return $response->withStatus(HttpStatusCodes::CREATED)->withHeader('Content-Type', 'application/json')->withBody($body);
  }

  public function updateCreature(Request $request, Response $response): Response {
    $parsedBody = $request->getParsedBody();
    $id = $request->getAttribute('id');
    $this->creatureRepository->update($id, $parsedBody);;
    $body = $response->getBody();
    $messageResponse = [ 'message' => 'Creature updated' ];
    $body->write(json_encode($messageResponse));
    return $response->withStatus(HttpStatusCodes::OK)->withHeader('Content-Type', 'application/json')->withBody($body);
  }

  // public function deleteCreature(Request $request, Response $response): Response


}