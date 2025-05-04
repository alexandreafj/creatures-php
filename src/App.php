<?php

namespace App;

use Slim\Factory\AppFactory;
use App\Handlers\HttpErrorHandler;
use App\Handlers\ShutdownHandler;
use Slim\Factory\ServerRequestCreatorFactory;
use App\Controller\CreaturesController;

class App {
  private static $app;
  private static $callableResolver;
  private static $responseFactory;
  private static $serverRequestCreator;
  private static $errorHandler;
  private static $shutdownHandler;
  private static $request;
  public function __construct() {
    self::$app = AppFactory::create();  
  }

  private function initErrorHandler() {
    self::$callableResolver = self::$app->getCallableResolver();
    self::$responseFactory = self::$app->getResponseFactory();
    self::$serverRequestCreator = ServerRequestCreatorFactory::create();
    self::$request = self::$serverRequestCreator->createServerRequestFromGlobals();
    self::$errorHandler = new HttpErrorHandler(self::$callableResolver, self::$responseFactory);
    self::$shutdownHandler = new ShutdownHandler(self::$request, self::$errorHandler, true);
    register_shutdown_function(self::$shutdownHandler);
  }

  private function initMiddlewares() {
    self::$app->addBodyParsingMiddleware();
    self::$app->addRoutingMiddleware();
  }

  private function initErrorMiddleware() {
    $errorMiddleware = self::$app->addErrorMiddleware(true, false, false);
    $errorMiddleware->setDefaultErrorHandler(self::$errorHandler);
  }

  private function initRoutes() {
    self::$app->get('/api/creatures', [CreaturesController::class, 'listCreatures']);
    self::$app->post('/api/creatures', [CreaturesController::class, 'createCreature']);
    self::$app->put('/api/creatures/{id}', [CreaturesController::class, 'updateCreature']);
    // $app->delete('/api/creatures/{id}', [CreaturesController::class, 'deleteCreature']);
    // $app->get('/api/creatures/{id}', [CreaturesController::class, 'getCreatureById']);
  }

  public function run() {
    $this->initErrorHandler();

    $this->initMiddlewares();

    $this->initErrorMiddleware();

    $this->initRoutes();
    
    return self::$app->run();
  }
}