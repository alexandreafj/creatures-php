# Docker PHP Development Environment with Xdebug

This document outlines the setup for a PHP development environment using Docker (PHP-FPM, Nginx, MySQL) and configuring Xdebug for step debugging with VS Code.

## Overview

This setup uses Docker Compose to manage containers for:
* **PHP:** Runs PHP-FPM with Xdebug installed.
* **Nginx:** Acts as a web server, proxying PHP requests to the PHP-FPM container.
* **MySQL:** Provides a database service.

## Why PHP-FPM(FastCGI)?
I'm using PHP-FPM, a FastCGI implementation, because it offers significant advantages over traditional CGI, here's a couple of whys it's better:
* **`Performance`**: FastCGI uses persistent PHP processes, eliminating the overhead of starting a new process for each request.
* **`Efficiency`**: Reduces server load, allowing it to handle more concurrent requests.
* **`Scalability`**: Enables easier scaling of PHP applications.
* **`Security`**: Improves security by allowing the web server and PHP processes to run under different user accounts.

## Basic Composer Commands

Composer is a dependency manager for PHP. Here are some essential commands:

* **`composer install`**: Installs the dependencies listed in the `composer.json` file. If a `composer.lock` file exists, it will install the exact versions specified there.
* **`composer update`**: Updates the dependencies to the latest versions that satisfy the version constraints specified in `composer.json`, and updates the `composer.lock` file.
* **`composer require <package-name>`**: Adds a new dependency to the `composer.json` file and installs it. For example: `composer require monolog/monolog`. You can also specify a version: `composer require monolog/monolog:1.24`.
* **`composer remove <package-name>`**: Removes a dependency from the `composer.json` file and uninstalls it.
* **`composer dump-autoload`**: Regenerates the autoloader. This is necessary if you create new classes and they are not being autoloaded. Often not needed, as `install`, `update`, and `require` do this.
* **`composer show <package-name>`**: Shows information about a specific package. For example: `composer show monolog/monolog`. Without a package name, it shows all installed packages.
* **`composer validate`**: Validates that your `composer.json` file is valid.
* **`composer clear-cache`**: Clears Composer's cache. This can sometimes resolve issues with package installation or updates.
* **`composer serve`**: Runs PHP's built-in web server. Useful for development. You can specify the host and port (e.g., `composer serve --host=0.0.0.0 --port=8080`).

## Starting

## Getting Started

To start using this development environment, follow these steps:

### Prerequisites

Before you begin, ensure you have the following installed on your system:

* **Docker:** [Get Docker](https://www.docker.com/get-started/)
* **Docker Compose:** (Usually included with Docker Desktop, but check your installation)

### Setup

1.  **Clone the repository:**
    ```bash
    git clone <your_repository_url>
    cd <your_repository_folder>
    ```
    *Replace `<your_repository_url>` and `<your_repository_folder>` with your actual repository details.*

2.  **Configure Environment Variables:**
    Copy the example environment file and update it with your specific settings if needed. This file (`.env`) is used by `docker-compose.yml` to configure services like the database.
    ```bash
    cp .env.template .env
    # Open .env in your editor and adjust settings if necessary (e.g., database credentials, ports)
    ```

3.  **Build and Start the Containers:**
    This command will build the Docker images (if they don't exist) and start the defined services (Nginx, PHP-FPM, MySQL) in detached mode (`-d`).
    ```bash
    docker compose up -d --build
    ```
    * `--build`: This ensures that your images are built, which is important the first time you run it or if you make changes to the Dockerfile.
    * `-d`: Runs the containers in the background.

4.  **Install PHP Dependencies:**
    Once the containers are running, you need to install your PHP dependencies using Composer. You'll run the `composer install` command inside the PHP container.
    First, identify the name of your PHP service container (it's likely `my_app_php` based on your example, but you can confirm with `docker compose ps`). Then execute:
    ```bash
    docker exec <php_container_name> composer install
    ```
    *Replace `<php_container_name>` with the actual name of your PHP service container (e.g., `docker exec my_app_php composer install`).*

### Accessing the Application

Your application should now be running and accessible through Nginx.

* Open your web browser and navigate to the address and port configured in your Nginx setup (usually `localhost` on a specific port, commonly 80 or 8080, as defined in your `nginx/default.conf` or `nginx.conf` and `docker-compose.yml`).

### Stopping the Environment

To stop the running containers, use:
```bash
docker compose down