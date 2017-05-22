# Ubuntu LAMP stack with Nginx, MariaDB, PHP, SSH and SSL

FROM phusion/baseimage

MAINTAINER Rafael

# Install Nginx, SSH, SSL, PHP, MariaDb, and some PHP modules

RUN apt-get update && apt-get install -y nginx \
 openssl \
 php \
 php-cgi \
 php-mysql \
 php-gd \
 php-cli \
 php-fpm \
 php-curl \
 php-pear \
 php-mcrypt \
 php-opcache \
 php-apcu \
 openssh-server \
 supervisor \
 mariadb-server

# Nginx configuration
ADD default /etc/nginx/sites-available/

# SSH login
#RUN mkdir /var/run/sshd
RUN echo 'root:screencast' | chpasswd
RUN sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config

# SSH login fix. Otherwise user is kicked off after login
RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd

ENV NOTVISIBLE "in users profile"
RUN echo "export VISIBLE=now" >> /etc/profile

# Install MariaDB and set default root password

#RUN echo 'mariadb-server mariadb-server/root_password  password abc@123' | debconf-set-selections
#RUN echo 'mariadb-server mariadb-server/root_password_again password abc@123' | debconf-set-selections
#RUN apt-get install mariadb-server -y

# PHP FastCGI script
ADD php-fcgi /usr/local/sbin/
RUN chmod o+x /usr/local/sbin/php-fcgi

# Supervisor configuration files
ADD supervisord.conf /etc/supervisor/
ADD supervisor-lemp.conf /etc/supervisor/conf.d/

# Basic PHP website
ADD index.php /var/www/html/

# Create new MySQL admin user
RUN service mysql start; mysql -u root -e "CREATE USER 'admin'@'%' IDENTIFIED BY 'pass';";mysql -u root -e "GRANT ALL PRIVILEGES ON *.* TO 'admin'@'%' WITH GRANT OPTION;";

# MySQL configuration
RUN echo 'bind-address = 0.0.0.0' >> /etc/mysql/my.cnf

# Remove APT files
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 443 80 3306 22

CMD ["supervisord"]
