# Simple Project Steps

This is the short version you can reuse for other TYPO3 projects.

## Local Setup

1. Create the TYPO3 v13 project with Composer.
2. Configure DDEV with `public` as docroot.
3. Start DDEV.
4. Run the TYPO3 installer locally.
5. Install the Introduction Package.
6. Verify the demo site works.

## Git Setup

1. Initialize Git.
2. Set branch to `main`.
3. Add remote GitHub repository.
4. Commit the clean TYPO3 baseline.
5. Push to GitHub.

## Server Setup

1. Connect to the Google Cloud VM.
2. Install Nginx, PHP-FPM, Composer, Git, and required PHP extensions.
3. Create the deploy path in `/var/www/...`.
4. Give deploy user and `www-data` correct permissions.
5. Configure Nginx to point to `current/public`.
6. Verify GitHub SSH access from the VM.

## Deployer Setup

1. Install Deployer in the project.
2. Create `deploy.php`.
3. Set repo URL, server IP, SSH user, branch, and deploy path.
4. Configure shared TYPO3 folders.
5. Run the first deployment.
6. Verify frontend, backend, and logs.

## For This Project

1. Repo: `git@github.com:ayushN2T/d13.git`
2. Branch: `main`
3. Server IP: `34.131.188.94`
4. SSH user: `net2t`
5. Deploy path: `/var/www/typo3-demo`
