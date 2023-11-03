FROM mcr.microsoft.com/devcontainers/php:1-8.2-bullseye

# Install MariaDB client
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y libicu-dev \ 
    && apt-get install -y mariadb-client \ 
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

# Install php-mysql driver
RUN docker-php-ext-install mysqli pdo pdo_mysql intl

# [Optional] Uncomment this section to install additional OS packages.
# RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
#     && apt-get -y install --no-install-recommends <your-package-list-here>

# [Optional] Uncomment this line to install global node packages.
# RUN su vscode -c "source /usr/local/share/nvm/nvm.sh && npm install -g <your-package-here>" 2>&1

# Config xdebug
# RUN echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.client_port = 9003" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.discover_client_host = yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request = trigger" >> /usr/local/etc/php/conf.d/xdebug.ini

# Copy vhost config
RUN a2enmod headers http2 rewrite setenvif ssl 
COPY ./ssl/*.pem /etc/apache2/ssl/
COPY ./apache2/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN sed -i "s/443/8443/g" /etc/apache2/ports.conf

EXPOSE 8443
