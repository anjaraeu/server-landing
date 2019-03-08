# Server Landing Page - by Anjara :tm:

## Requirements

- php-fpm (7.x)
- php-cli (7.x)
- composer
- nginx
- systemd

## Install

- Clone the repo somewhere.

`cd /opt ; git clone https://github.com/anjaraeu/server-landing.git`

- Install composer requirements

`cd socket-server; composer install`

- Link the systemd service of the server-socket app.

`ln -s /opt/server-landing/systemd/socket-server.service /etc/systemd/system/`

- Reload the daemons and enable the service.

`systemctl daemon-reload ; systemctl enable socket-server`

- Start the service.

`systemctl start socket-server`

- Link the web files.

`ln -s /opt/server-landing/www /var/www/server-landing`

- Copy the nginx configuration.

`cp /opt/server-landing/nginx/server-landing.conf /etc/nginx/sites-enabled/`

- Edit the configuration (replace all the domain.tld and check the php block if you are not using php-fpm7.3).

`nano /etc/nginx/sites-enabled/server-landing.conf`

- Reload nginx

`nginx -s reload`

- (optional) Add a gif.

If your server hostname is `srv-app-1` for exemple, your gif name must be `srv-app-1.gif`.
Put your gif file in `/opt/server-landing/www/`.