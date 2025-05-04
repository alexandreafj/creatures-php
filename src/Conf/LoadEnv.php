<?php

namespace App\Conf;
use Dotenv;

class LoadEnv {
  /**
   * Load the .env file.
   *
   * @throws \RuntimeException if the .env file cannot be loaded
   */
  public static function load(): void {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    try {
      $dotenv->load();
    } catch (Dotenv\Exception\InvalidPathException $e) {
      throw new \RuntimeException("Could not load .env file. Please check your configuration.", 0, $e);
    }
  }
}