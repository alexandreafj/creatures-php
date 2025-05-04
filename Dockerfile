# Use an official PHP-FPM image
# Replace 8.x with the PHP version you need (e.g., 8.2, 8.3)
FROM php:8.2-fpm

# Install necessary system dependencies for extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libfreetype6-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    webp \
    unzip \
    git \
    curl \
    vim \
    # Clean up apt cache to reduce image size
    && rm -rf /var/lib/apt/lists/*

# <<< --- ADD XDEBUG INSTALLATION --- >>>
# Install Xdebug via PECL
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
# <<< --- END XDEBUG INSTALLATION --- >>>

# Install common PHP extensions
# The docker-php-ext-install command automatically enables them
RUN docker-php-ext-install \
    pdo_mysql \
    zip \
    gd # GD is useful for image manipulation

# Optional: Install Composer globally in the container
# COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the application code from the host to the container
# This is often done via volumes in docker-compose for local dev,
# but can be useful here if you build the image with code baked in.
# COPY . /var/www/html

# The default command for php-fpm is usually sufficient
CMD ["php-fpm"]

# Expose port 9000 for PHP-FPM (not Xdebug)
EXPOSE 9000