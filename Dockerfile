FROM dunglas/frankenphp:php8.3

RUN apt update && apt install -y curl zip unzip libpq-dev libzip-dev git

RUN docker-php-ext-install pdo pdo_pgsql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ARG USER=appuser

RUN useradd ${USER}; \
    # Только если порт >=1024
	setcap -r /usr/local/bin/frankenphp; \
	chown -R ${USER}:${USER} /data/caddy; \
    chown -R ${USER}:${USER} /config/caddy

USER ${USER}

ENV SERVER_NAME=:8080
