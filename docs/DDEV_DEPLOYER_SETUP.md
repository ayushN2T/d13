# DDEV + Deployer Setup

This note explains:

- what `.github/workflows/deploy.yml` does
- what `deploy.php` does
- what we actually changed in DDEV
- what you need to repeat in another DDEV project

## 1. What `.github/workflows/deploy.yml` Does

This GitHub Actions workflow automates production deployment on every push to `main`.

Current flow:

1. Check out the repository.
2. Install PHP and Composer on the GitHub runner.
3. Run `composer install` so `vendor/bin/dep` exists.
4. Start an SSH agent and load the private key from the GitHub secret `SSH_PRIVATE_KEY`.
5. Add the production server to `known_hosts`.
6. Test raw SSH login to the server.
7. Run Deployer with:

```bash
php vendor/bin/dep deploy production -vvv
```

Important detail:

- The workflow does not deploy by itself.
- It only prepares the environment and then runs `deploy.php` through Deployer.

## 2. What `deploy.php` Does

`deploy.php` is the actual deployment definition for the server.

In this project it tells Deployer:

- which server to connect to
- which SSH user to use
- where the app lives on the server
- which repository to pull
- which directories are shared between releases
- which directories must be writable
- which custom deployment tasks to run

Current important settings:

- repository: `https://github.com/ayushN2T/d13.git`
- host: `34.131.188.94`
- remote user: `net2t`
- deploy path: `/var/www/typo3-demo`
- TYPO3 webroot: `public`

Important TYPO3-specific behavior:

- `public/fileadmin`, `public/typo3temp`, and `var` are shared across releases
- `config/system/settings.php` and `config/system/additional.php` are shared files
- a custom task creates the shared TYPO3 paths if they do not exist yet
- a custom task fixes permissions for `www-data`

Why that matters:

- TYPO3 in this repo uses `public/`, not the recipe default `Web/`
- without these overrides, deploys succeed but the live site breaks

## 3. What We Changed In DDEV

We did not change the repo's `.ddev/` project config for deployment.

What mattered was:

1. DDEV provides PHP, so `vendor/bin/dep` can run inside the container.
2. The container must have access to an SSH key that can log into the server.

The main DDEV-related actions were:

- run deployment from inside DDEV because the host shell did not have PHP
- use host SSH agent / keys so the container could authenticate

This was the command used:

```bash
ddev exec "vendor/bin/dep deploy production"
```

or equivalently:

```bash
ddev exec "php vendor/bin/dep deploy production -vvv"
```

## 4. Why `ddev exec "vendor/bin/dep deploy production"` Did Not Work Immediately

It only works if all of these are already true:

1. `vendor/bin/dep` exists
2. DDEV is running
3. the container has PHP
4. the container can authenticate over SSH to the target server
5. the server user has permission to write to the deploy path

In this project, the main blockers were:

- local host did not have PHP
- DDEV initially did not have the right SSH identity for the server
- GitHub Actions had a different SSH key/user mapping than local deploy
- TYPO3 recipe defaults did not match this repo structure

## 5. What You Need For Another DDEV Project

For another DDEV project, this command:

```bash
ddev exec "vendor/bin/dep deploy production"
```

will work only if you set up all of the following first.

### A. Inside the repo

You need:

- a valid `deploy.php`
- `deployer/deployer` installed via Composer
- the right server host/user/path/repository
- correct shared and writable dirs for that project

### B. On the server

You need:

- the deploy user to exist
- the deploy user's public SSH key in `~/.ssh/authorized_keys`
- permission for that user to write into the deploy path
- web server config pointing at the Deployer `current` symlink

### C. In DDEV

You need:

- DDEV running
- Composer dependencies installed
- SSH access available inside the DDEV container

## 6. Recommended Repeatable Steps For Another DDEV Project

Use this checklist.

### Local / DDEV

1. Start DDEV:

```bash
ddev start
```

2. Install dependencies:

```bash
ddev composer install
```

3. Confirm Deployer exists:

```bash
ddev exec "php vendor/bin/dep --version"
```

4. Confirm the container has SSH access.

A simple test:

```bash
ddev exec "ssh -o StrictHostKeyChecking=no your-user@your-server 'whoami'"
```

If that fails, Deployer will also fail.

### Server

1. Create or choose one deploy user.
2. Put the matching public key into that user's `authorized_keys`.
3. Make sure that same user can write into the deploy path.
4. Make Nginx or Apache serve:

```text
/your/deploy/path/current/public
```

or whatever the correct webroot is for the app.

### App config

1. Set the right webroot in `deploy.php`.
2. Define shared dirs and files correctly.
3. Define writable dirs correctly.
4. Test a first manual deploy before trying CI.

## 7. Best Practice

Pick one deployment user and use it everywhere:

- local manual deploy
- DDEV deploy
- GitHub Actions deploy

Do not mix:

- one SSH key for local under user A
- another SSH key for CI under user B

unless you deliberately manage both. That mismatch caused the `255` error in this project.

## 8. Practical Rule

Before relying on this command:

```bash
ddev exec "vendor/bin/dep deploy production"
```

verify these two commands first:

```bash
ddev exec "php vendor/bin/dep --version"
ddev exec "ssh your-user@your-server 'whoami'"
```

If both work, the Deployer command is usually ready to work too.
