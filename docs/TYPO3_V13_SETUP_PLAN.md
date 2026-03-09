# TYPO3 v13 + Introduction Package + Deployer + Google Cloud Plan

> Assumption: your deployment target is a Google Compute Engine VM inside your Google Cloud VPC. A VPC is the network; the actual deploy target is a VM.

## Approach

Start with a Composer-based TYPO3 v13 installation, run it locally with DDEV, add the official Introduction Package, lock the project in Git, then add Deployer as a project dev dependency so the deploy process is versioned with the app. After that, prepare the Google Cloud VM and use Deployer over SSH with the existing `net2t` user for the first deployment.

## Scope

- In:
  - TYPO3 v13 bootstrap
  - Introduction Package installation
  - Deployer installation and basic deployment setup
  - First deployment plan to Google Cloud VM
- Out:
  - Full production hardening
  - Managed database setup
  - CI/CD pipeline automation
  - DNS and SSL automation details

## Important Note About This Folder

`composer create-project` expects the target directory to be completely empty. Because this plan file now exists in `/home/net2t/projects/d13`, do one of these before Step 1:

1. Move this file temporarily outside the folder, then run `composer create-project` into `d13`
2. Run the command from the parent directory and target a fresh folder name
3. Keep this folder only for planning and create the TYPO3 app in a subfolder such as `app/`

Recommended: run the install from `/home/net2t/projects` and target `d13`.

## Step-by-Step Plan

### Step 1: Prepare Local Requirements

Install and verify these tools locally:

- Git
- DDEV
- Docker / Docker Engine
- Optional local tools outside containers:
  - PHP 8.2 or 8.3
  - Composer 2.x

Validation commands:

```bash
git --version
ddev version
docker --version
```

### Step 2: Create the TYPO3 v13 Project

From the parent directory `/home/net2t/projects`, create the project:

```bash
cd /home/net2t/projects
composer create-project "typo3/cms-base-distribution:^13" d13
cd d13
```

Expected result:

- `composer.json`
- `composer.lock`
- `public/`
- `vendor/`
- `var/`

### Step 3: Configure DDEV for TYPO3

Inside the TYPO3 project root:

```bash
ddev config --project-type=typo3 --docroot=public --create-docroot=false
ddev start
```

Then verify DDEV services:

```bash
ddev describe
ddev php -v
ddev composer --version
```

Expected result:

- DDEV creates `.ddev/`
- The web container is running
- The project gets a local DDEV URL
- TYPO3 docroot is `public`

### Step 4: Configure and Run the Initial TYPO3 Install

Prepare your local web server and database, then complete the TYPO3 install.

Then:

1. Open the DDEV project URL
2. Use the DDEV database credentials shown by `ddev describe`
3. Complete the TYPO3 web installer
4. Confirm backend access works

If needed, use DDEV shell commands:

```bash
ddev ssh
```

### Step 5: Install the Official Introduction Package

Inside the TYPO3 project root:

```bash
ddev composer require typo3/cms-introduction
ddev composer exec typo3 extension:setup
```

Expected result:

- `bootstrap_package` is present as dependency
- TYPO3 imports demo content
- Frontend root page appears as `Congratulations`

Verification:

1. Log into TYPO3 backend
2. Confirm the page tree contains `Congratulations`
3. Open the frontend and confirm the demo site renders

### Step 6: Commit the Clean Baseline

Initialize Git if needed and save the working baseline before adding deployment code:

```bash
git init
git branch -M main
git remote add origin git@github.com:ayushN2T/d13.git
git add .
git commit -m "chore: bootstrap TYPO3 v13 with introduction package"
git push -u origin main
```

### Step 7: Install Deployer in the Project

Install Deployer as a project dependency:

```bash
composer require --dev deployer/deployer
```

Optional convenience alias:

```bash
alias dep='vendor/bin/dep'
```

Initialize Deployer:

```bash
vendor/bin/dep init
```

If available in your chosen Deployer version, prefer the TYPO3 recipe instead of a generic PHP recipe.
Confirm the exact recipe path during `dep init`, because Deployer installation guidance is versioned separately from some TYPO3 recipe examples.

### Step 8: Create the Deployment Structure

Target structure on the VM should look like this:

```text
/var/www/your-project
├── current -> releases/20260309000123
├── releases/
├── shared/
│   ├── public/fileadmin/
│   ├── var/
│   └── config/system/
```

Minimum shared paths to plan for:

- `public/fileadmin`
- `var`
- `config/system`

### Step 9: Prepare the Google Cloud VM

Create or choose a Compute Engine VM inside your Google Cloud VPC.

Recommended baseline:

- Ubuntu 22.04 LTS or 24.04 LTS
- Nginx or Apache
- PHP-FPM 8.2+
- MariaDB/MySQL if DB is local to the VM
- Composer
- Git
- Unzip
- Rsync

Known current access:

```bash
gcloud compute ssh --zone "asia-south2-a" "deployer" --project "project-204d29c9-73a8-4ffa-99a"
```

Current Linux user observed:

```text
net2t@deployer:~$
```

Server tasks for the first setup:

1. Confirm `net2t` can SSH into the VM
2. Use `net2t` as the first Deployer SSH user
3. Create the app base path, for example `/var/www/typo3-demo`
4. Set web server document root to `/var/www/typo3-demo/current/public`
5. Install PHP extensions required by TYPO3
6. Grant `net2t` and `www-data` the correct shared access

Recommended first permission model:

```bash
sudo mkdir -p /var/www/typo3-demo
sudo chown -R net2t:www-data /var/www/typo3-demo
sudo chmod -R 2775 /var/www/typo3-demo
sudo usermod -aG www-data net2t
```

Then log out and SSH back in so the group change applies.

Validation:

```bash
whoami
hostname
php -v
composer --version
```

Also fetch the VM public IP from your machine:

```bash
gcloud compute instances describe deployer \
  --zone=asia-south2-a \
  --project=project-204d29c9-73a8-4ffa-99a
```

Look for:

- `networkInterfaces[0].accessConfigs[0].natIP`

### Step 10: Configure `deploy.php`

Create a project deployment file in the TYPO3 root:

```php
<?php

namespace Deployer;

require 'recipe/typo3.php';

set('application', 'typo3-demo');
set('repository', 'git@github.com:ayushN2T/d13.git');
set('remote_user', 'net2t');
set('deploy_path', '/var/www/typo3-demo');
set('typo3_webroot', 'public');

add('shared_files', [
    'config/system/settings.php',
    'config/system/additional.php',
]);
add('shared_dirs', [
    'public/fileadmin',
    'var',
]);

host('production')
    ->setHostname('34.131.188.94')
    ->setRemoteUser('net2t')
    ->setForwardAgent(true);
```

Then extend it with project-specific tasks such as:

- database migrations
- TYPO3 cache flush
- permissions fix
- frontend asset build if needed

### Step 11: Prepare Repository Access for Deployments

Deployer normally pulls your repository on the server. That means the server must be able to read your Git repository.

Choose one:

1. Add a deploy key to the Git repository
2. Use SSH agent forwarding for manual deployments

Recommended for production: deploy key with read-only repository access.

### Step 12: Run the First Deployment

From the project root:

```bash
vendor/bin/dep deploy production
```

After deploy, verify:

```bash
ssh net2t@YOUR_VM_IP
ls -la /var/www/typo3-demo
ls -la /var/www/typo3-demo/current
```

Then open the website in the browser and check:

1. TYPO3 frontend loads
2. Backend loads
3. `fileadmin` persists across releases
4. No permission errors appear in logs

### Step 13: Add Safe Post-Deploy Tasks

Plan these after the first successful deploy:

- flush TYPO3 caches
- run database schema updates when required
- restart PHP-FPM only if needed
- keep last 3 to 5 releases
- define rollback command

Typical commands to wire into Deployer tasks:

```bash
vendor/bin/typo3 cache:flush
vendor/bin/typo3 upgrade:run
vendor/bin/dep rollback production
```

### Step 14: Harden Before Real Production Use

Before calling it production-ready, add:

1. Domain and DNS
2. HTTPS with Let's Encrypt
3. Backups for database and `public/fileadmin`
4. Firewall rules
5. Fail2ban or equivalent SSH protection
6. Monitoring and log review
7. Separate staging and production hosts

## Action Checklist

- [ ] Verify Git, DDEV, and Docker locally
- [ ] Create TYPO3 v13 Composer project
- [ ] Configure DDEV with `public` docroot
- [ ] Start DDEV and verify local services
- [ ] Complete the initial TYPO3 install
- [ ] Install `typo3/cms-introduction`
- [ ] Run `ddev composer exec typo3 extension:setup`
- [ ] Verify the `Congratulations` demo site
- [ ] Commit the clean TYPO3 baseline
- [ ] Install `deployer/deployer`
- [ ] Initialize `deploy.php`
- [ ] Confirm VM public IP from `gcloud compute instances describe`
- [ ] Create the Google Cloud VM
- [ ] Verify SSH login to the VM as `net2t`
- [ ] Install server packages and PHP extensions
- [ ] Grant `net2t` and `www-data` correct shared access
- [ ] Configure web server docroot to `current/public`
- [ ] Add Git deploy key or agent forwarding
- [ ] Configure shared files and directories
- [ ] Run first `dep deploy production`
- [ ] Verify frontend, backend, logs, and shared storage

## Validation

Success means all of these are true:

- TYPO3 v13 installs cleanly
- TYPO3 runs locally via DDEV
- Introduction Package loads and shows the demo site
- Deployer connects to the VM by SSH as `net2t`
- A release is created under `releases/`
- `current` points to the latest release
- Frontend and backend both work after deployment

## Open Questions

- Which web server do you want on the VM: Nginx or Apache?
- Will the database run on the same VM or on a managed Google Cloud database?
- What is the VM public IP or final domain?
- Confirm Nginx + PHP-FPM on the VM
- Confirm the server can read `git@github.com:ayushN2T/d13.git`

## Recommended Next Order

1. Bootstrap TYPO3 locally
2. Configure DDEV and confirm local TYPO3 works
3. Confirm the Introduction Package works
4. Commit to Git
5. Push `main` to GitHub
6. Add Deployer
7. Prepare the Google Cloud VM
8. Configure `deploy.php`
9. Run first deployment

## Reference Sources Used

- TYPO3 Composer install docs: https://docs.typo3.org/permalink/t3coreapi%3Ainstallation-composer
- TYPO3 Introduction Package docs: https://docs.typo3.org/m/typo3/tutorial-getting-started/main/en-us/ProjectTemplates/IntroductionPackage/Index.html
- TYPO3 Introduction Package installation reference: https://docs.typo3.org/p/typo3/cms-introduction/main/en-us/Installation.html
- Deployer installation docs: https://deployer.org/docs/8.x/installation
- Deployer TYPO3 recipe docs: https://deployer.org/docs/7.x/recipe/typo3
