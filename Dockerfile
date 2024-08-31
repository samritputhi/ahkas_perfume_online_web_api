FROM php:8.1-cli

RUN apt-get update -y && apt-get install -y \
    libmcrypt-dev \
    git \
    openssl \
    zip \
    unzip \
    curl \
    libpng-dev \
    libpq-dev \
    build-essential \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libgd-dev \
    jpegoptim optipng pngquant gifsicle \
    libonig-dev \
    libxml2-dev \
    sudo

# Clear cache
# RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pgsql pdo_pgsql mbstring exif pcntl bcmath gd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

WORKDIR /app
COPY . /app
ARG APP_URL
ARG LOG_CHANNEL
ARG DB_CONNECTION
ARG DB_HOST
ARG DB_PORT
ARG DB_DATABASE
ARG DB_PASSWORD
ARG DB_USERNAME
ARG PERFUME_TELEGRAM_TOKEN
ARG PERFUME_TELEGRAM_GROUP
ARG FILESYSTEM_DISK
ARG SCOUT_DRIVER
ARG MEILISEARCH_HOST
ARG MEILISEARCH_KEY

RUN composer install --ignore-platform-reqs
RUN touch .env && \
    echo "APP_KEY=$APP_KEY" >> .env && \
    echo "APP_URL=$APP_URL" >> .env && \
    echo "ASSET_URL=$APP_URL" >> .env && \
    echo "LOG_CHANNEL='${LOG_CHANNEL}'" >> .env && \
    echo "DB_CONNECTION='${DB_CONNECTION}'" >> .env && \
    echo "DB_HOST='${DB_HOST}'" >> .env && \
    echo "DB_PORT='${DB_PORT}'" >> .env && \
    echo "DB_DATABASE='${DB_DATABASE}'" >> .env && \
    echo "DB_USERNAME='${DB_USERNAME}'" >> .env && \
    echo "DB_PASSWORD='${DB_PASSWORD}'" >> .env && \
    echo "PERFUME_TELEGRAM_TOKEN='${PERFUME_TELEGRAM_TOKEN}'" >> .env && \
    echo "PERFUME_TELEGRAM_GROUP='${PERFUME_TELEGRAM_GROUP}'" >> .env && \
    echo "FILESYSTEM_DISK='${FILESYSTEM_DISK}'" >> .env && \
    echo "FILAMENT_FILESYSTEM_DISK='${FILESYSTEM_DISK}'" >> .env && \
    echo "SCOUT_DRIVER='${SCOUT_DRIVER}'" >> .env && \
    echo "MEILISEARCH_HOST='${MEILISEARCH_HOST}'" >> .env && \
    echo "MEILISEARCH_KEY='${MEILISEARCH_KEY}'" >> .env

RUN php artisan key:generate && \
    php artisan cache:clear && \
    php artisan config:clear

RUN php artisan migrate --force

# RUN curl -X POST -H 'Content-Type: application/json' -d '{"chat_id":'"${PERFUME_TELEGRAM_GROUP}"', "text": "VIREAK PERFUME Back-end new version deployed"}' https://api.telegram.org/bot"${PERFUME_TELEGRAM_TOKEN}"/sendMessage

EXPOSE 80
