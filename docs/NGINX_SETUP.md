# Nginx Setup For TYPO3 v13

Use this on the Google Cloud VM with:

- IP: `34.131.188.94`
- App path: `/var/www/typo3-demo`
- Public web root: `/var/www/typo3-demo/current/public`

## 1. Install Nginx And PHP

```bash
sudo apt update
sudo apt install -y nginx git unzip curl software-properties-common
sudo add-apt-repository -y ppa:ondrej/php
sudo apt update
sudo apt install -y \
  php8.3-fpm php8.3-cli php8.3-common php8.3-mysql php8.3-xml php8.3-curl \
  php8.3-zip php8.3-gd php8.3-intl php8.3-mbstring php8.3-soap php8.3-bcmath
```

If you prefer PHP 8.2, replace `8.3` with `8.2`.

## 2. Create TYPO3 Nginx Site Config

Create:

```text
/etc/nginx/sites-available/typo3-demo
```

Use this config:

```nginx
server {
    listen 80;
    server_name 34.131.188.94;

    root /var/www/typo3-demo/current/public;
    index index.php;

    access_log /var/log/nginx/typo3-demo.access.log;
    error_log /var/log/nginx/typo3-demo.error.log;

    client_max_body_size 64M;

    location / {
        try_files $uri /index.php$is_args$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|webp|woff|woff2)$ {
        expires 7d;
        access_log off;
        add_header Cache-Control "public";
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

If using PHP 8.2, change:

```text
/run/php/php8.3-fpm.sock
```

to:

```text
/run/php/php8.2-fpm.sock
```

## 3. Enable The Site

```bash
sudo ln -s /etc/nginx/sites-available/typo3-demo /etc/nginx/sites-enabled/typo3-demo
sudo nginx -t
sudo systemctl reload nginx
```

## 4. Remove Default Site If Needed

```bash
sudo rm -f /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl reload nginx
```

## 5. Open Firewall Ports

Make sure these are allowed:

- `22` for SSH
- `80` for HTTP
- `443` for HTTPS later

## 6. Verify

```bash
systemctl status nginx
systemctl status php8.3-fpm
curl -I http://34.131.188.94
```

## Notes

- This is the simple first setup.
- Add HTTPS later when you have a domain.
- TYPO3 public root must stay `current/public`.
