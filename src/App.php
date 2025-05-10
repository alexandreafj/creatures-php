<?php

namespace App;

use Slim\Factory\AppFactory;
use App\Handlers\HttpErrorHandler;
use App\Handlers\ShutdownHandler;
use Slim\Factory\ServerRequestCreatorFactory;
use App\Controller\CreaturesController;

class App {
  private static $app = null;
  private static $callableResolver = null;
  private static $responseFactory = null;
  private static $serverRequestCreator = null;
  private static $errorHandler = null;
  private static $shutdownHandler = null;
  private static $request = null;
  public function __construct() {
    self::$app = AppFactory::create();  
  }

  private function initErrorHandler(): void {
    self::$callableResolver = self::$app->getCallableResolver();
    self::$responseFactory = self::$app->getResponseFactory();
    self::$serverRequestCreator = ServerRequestCreatorFactory::create();
    self::$request = self::$serverRequestCreator->createServerRequestFromGlobals();
    self::$errorHandler = new HttpErrorHandler(self::$callableResolver, self::$responseFactory);
    self::$shutdownHandler = new ShutdownHandler(self::$request, self::$errorHandler, true);
    register_shutdown_function(self::$shutdownHandler);
  }

  private function initMiddlewares(): void {
    self::$app->addBodyParsingMiddleware();
    self::$app->addRoutingMiddleware();
  }

  private function initErrorMiddleware(): void {
    $errorMiddleware = self::$app->addErrorMiddleware(true, false, false);
    $errorMiddleware->setDefaultErrorHandler(self::$errorHandler);
  }

  private function initRoutes(): void {
    self::$app->get('/api/creatures', [CreaturesController::class, 'listCreatures']);
    self::$app->post('/api/creatures', [CreaturesController::class, 'createCreature']);
    self::$app->put('/api/creatures/{id}', [CreaturesController::class, 'updateCreature']);
    // $app->delete('/api/creatures/{id}', [CreaturesController::class, 'deleteCreature']);
    // $app->get('/api/creatures/{id}', [CreaturesController::class, 'getCreatureById']);
  }

  public function run(): void {
    $this->initErrorHandler();

    $this->initMiddlewares();

    $this->initErrorMiddleware();

    $this->initRoutes();
    
    self::$app->run();
  }
}