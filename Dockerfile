FROM php:8.3-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
  git \
  unzip \
  libpq-dev \
  libzip-dev \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libonig-dev \
  libxml2-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath opcache intl \
  && pecl install -o -f redis-7.2.4 \
  && docker-php-ext-enable redis \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

# Set recommended PHP configurations
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Set timezone
RUN echo "date.timezone = America/Sao_Paulo" > "$PHP_INI_DIR/conf.d/timezone.ini"

# Set Laravel recommended opcache settings
# RUN echo "opcache.enable=1" >> "$PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini" && \
#   echo "opcache.memory_consumption=128" >> "$PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini" && \
#   echo "opcache.max_accelerated_files=10000" >> "$PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini" && \
#   echo "opcache.validate_timestamps=0" >> "$PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini" && \
#   echo "opcache.save_comments=1" >> "$PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini"

RUN groupadd --gid 1000 appuser \
  && useradd --uid 1000 -g appuser \
  -G www-data,root --shell /bin/bash \
  --create-home appuser

USER appuser
