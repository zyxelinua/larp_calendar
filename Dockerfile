FROM ubuntu:18.04

RUN apt update
RUN DEBIAN_FRONTEND=noninteractive apt install -yq --no-install-recommends php php-json php-curl php-ctype php-iconv php-pdo php-mysql php-dom php-zip composer apache2 libapache2-mod-php
COPY entrypoint.sh /opt/entrypoint.sh

RUN mkdir /var/www/rolendar
COPY larp.conf /etc/apache2/sites-available

WORKDIR /var/www/rolendar

RUN a2ensite larp && \
    a2enmod rewrite && \
    chmod +x /opt/entrypoint.sh

ENTRYPOINT ["/opt/entrypoint.sh"]

CMD /bin/bash
