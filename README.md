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

* **`composer install`**: Installs the dependencies listed in the `composer.json` file.  If a `composer.lock` file exists, it will install the exact versions specified there.
* **`composer update`**: Updates the dependencies to the latest versions that satisfy the version constraints specified in `composer.json`, and updates the `composer.lock` file.
* **`composer require <package-name>`**: Adds a new dependency to the `composer.json` file and installs it.  For example: `composer require monolog/monolog`.  You can also specify a version: `composer require monolog/monolog:1.24`.
* **`composer remove <package-name>`**: Removes a dependency from the `composer.json` file and uninstalls it.
* **`composer dump-autoload`**: Regenerates the autoloader.  This is necessary if you create new classes and they are not being autoloaded.  Often not needed, as `install`, `update`, and `require` do this.
* **`composer show <package-name>`**: Shows information about a specific package.  For example: `composer show monolog/monolog`.  Without a package name, it shows all installed packages.
* **`composer validate`**: Validates that your `composer.json` file is valid.
* **`composer clear-cache`**: Clears Composer's cache.  This can sometimes resolve issues with package installation or updates.
* **`composer serve`**: Runs PHP's built-in web server.  Useful for development.  You can specify the host and port (e.g., `composer serve --host=0.0.0.0 --port=8080`).



## Accessing the PHP Container

Sometimes you need to enter the running PHP container to check settings, run commands, or install tools.

### Enter the Container
Use `docker exec`. Replace `my_app_php` if your container has a different name.

```bash
docker exec -it my_app_php bash
```
To find the main php.ini
```bash
php --ini
```
Type exit and press Enter.
```bash
exit
```