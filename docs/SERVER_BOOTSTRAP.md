# Server Bootstrap For TYPO3 + Deployer

Target VM:

- VM name: `deployer`
- Zone: `asia-south2-a`
- Project: `project-204d29c9-73a8-4ffa-99a`
- Public IP: `34.131.188.94`
- SSH user: `net2t`

## 1. Connect To The VM

```bash
gcloud compute ssh --zone "asia-south2-a" "deployer" --project "project-204d29c9-73a8-4ffa-99a"
```

## 2. Update Packages

```bash
sudo apt update
sudo apt upgrade -y
```

## 3. Install Base Tools

```bash
sudo apt install -y git unzip curl rsync nginx software-properties-common
```

## 4. Install PHP And Extensions

```bash
sudo add-apt-repository -y ppa:ondrej/php
sudo apt update
sudo apt install -y \
  php8.3-fpm php8.3-cli php8.3-common php8.3-mysql php8.3-xml php8.3-curl \
  php8.3-zip php8.3-gd php8.3-intl php8.3-mbstring php8.3-soap php8.3-bcmath
```

## 5. Install Composer

```bash
cd /tmp
curl -sS https://getcomposer.org/installer -o composer-setup.php
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

## 6. Create Deploy Path

```bash
sudo mkdir -p /var/www/typo3-demo
sudo chown -R net2t:www-data /var/www/typo3-demo
sudo chmod -R 2775 /var/www/typo3-demo
sudo usermod -aG www-data net2t
```

Log out and connect again after the group change.

## 7. Check Repo Access

On the server, verify GitHub SSH access:

```bash
ssh -T git@github.com
```

If needed, create a key on the VM:

```bash
ssh-keygen -t ed25519 -C "deployer-vm"
cat ~/.ssh/id_ed25519.pub
```

Then add that public key to GitHub as a deploy key for:

```text
git@github.com:ayushN2T/d13.git
```

## 8. Create Shared Directories Early

```bash
mkdir -p /var/www/typo3-demo/shared/var
mkdir -p /var/www/typo3-demo/shared/public/fileadmin
mkdir -p /var/www/typo3-demo/shared/config/system
```

## 9. Verify Server Readiness

```bash
whoami
hostname
php -v
composer --version
nginx -v
git --version
```

## 10. Next Steps

1. Push TYPO3 project to GitHub
2. Configure Nginx
3. Make sure `config/system/settings.php` and `config/system/additional.php` are available as shared config
4. Run Deployer from local machine
