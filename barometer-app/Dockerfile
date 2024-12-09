FROM php:8.2

# Install dependencies for PHP and Node.js
RUN apt-get update -y && apt-get install -y \
    openssl \
    zip \
    unzip \
    git \
    libpq-dev \
    nodejs \
    npm

# Install Composer (for Laravel)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql

# Check for mbstring extension
RUN php -m | grep mbstring

# Set the working directory in the container
WORKDIR /app

# Copy project files into the container
COPY . /app

# Install PHP dependencies using Composer
RUN composer install

# Install React frontend dependencies using NPM
RUN npm install


# Expose the application port
EXPOSE 8000
EXPOSE 3000  

# Start the Laravel server
CMD php artisan serve --host=0.0.0.0 --port=8000 & npm run dev
