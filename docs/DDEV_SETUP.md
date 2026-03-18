# DDEV Setup

Use this for local TYPO3 v13 development.

## Current Project Values

- Project name: `d13`
- URL: `https://d13.ddev.site`
- PHP: `8.2`
- Web server: `apache-fpm`
- Database: `MariaDB 11.8`
- DB user/password: `db/db`

## Setup Steps

1. Create the TYPO3 project with Composer.
2. Configure DDEV:

```bash
ddev config --project-type=typo3 --docroot=public --create-docroot=false --project-name=d13
```

3. Start DDEV:

```bash
ddev start
```

4. Check the project:

```bash
ddev describe
```

5. Open TYPO3 locally:

```text
https://d13.ddev.site
```

6. Install additional packages with DDEV Composer:

```bash
ddev composer require typo3/cms-introduction
```

7. Run TYPO3 CLI commands with DDEV:

```bash
ddev composer exec typo3 extension:setup
```

## Useful Commands

```bash
ddev start
ddev stop
ddev restart
ddev ssh
ddev describe
ddev launch
```


