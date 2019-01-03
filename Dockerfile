FROM ubuntu:18.04

RUN apt update
RUN DEBIAN_FRONTEND=noninteractive apt install -yq --no-install-recommends php php-json php-curl php-ctype php-iconv php-pdo php-mysql php-dom php-zip composer apache2 libapache2-mod-php mysql-client sudo
RUN DEBIAN_FRONTEND=noninteractive apt-get install -yq --no-install-recommends cron
COPY entrypoint.sh /opt/entrypoint.sh

RUN mkdir -p /var/www/rolendar/backup
COPY larp.conf /etc/apache2/sites-available
COPY crontab /var/spool/cron/crontabs/root

WORKDIR /var/www/rolendar

RUN a2ensite larp && \
    a2enmod rewrite && \
    chmod +x /opt/entrypoint.sh

EXPOSE 80
EXPOSE 423

ENTRYPOINT ["/opt/entrypoint.sh"]

CMD /bin/bash
