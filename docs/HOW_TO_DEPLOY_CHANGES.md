# How to Deploy Changes to Production

This guide explains how to deploy different types of changes from your local DDEV environment to your Google Cloud VM.

## 1. Deploying Code Changes (PHP, Fluid, Extbase, config)

Any change to tracked files (like your custom extensions, composer packages, or configuration files outside of `fileadmin`) must be deployed via Git and Deployer.

**Step 1:** Commit and push your changes to GitHub:
```bash
git add .
git commit -m "feat: your descriptive message"
git push origin main
```

**Step 2:** Run the deployment via DDEV:
```bash
ddev exec "vendor/bin/dep deploy production"
```
Deployer will pull the latest code from GitHub and restart the necessary services.

---

## 2. Deploying User Uploads and Media (`fileadmin`)

The `public/fileadmin/` directory contains user-uploaded files, media, and images. **These are intentionally NOT tracked by Git**, which is why you initially got `404 Not Found` errors for pictures.

To sync local `fileadmin` files to the production server, use `rsync`:

```bash
# Sync local fileadmin to the remote server's shared fileadmin folder
rsync -avz -e "ssh -i ~/.ssh/google_compute_engine" public/fileadmin/ net2t@34.131.188.94:/var/www/typo3-demo/shared/public/fileadmin/

# Fix permissions on the server after upload
ssh -i ~/.ssh/google_compute_engine net2t@34.131.188.94 "sudo chown -R www-data:www-data /var/www/typo3-demo/shared/public/fileadmin/ && sudo chmod -R 775 /var/www/typo3-demo/shared/public/fileadmin/"
```

---

## 3. Deploying Database Changes

Depending on what changed in your database, you handle it differently.

### Pattern A: Schema Updates (New Extensions)
If you installed a new extension and it requires new database tables, TYPO3 can figure this out on its own.
Just run a normal code deployment (Step 1). Deployer will automatically run `typo3 database:updateschema` (if configured in `deploy.php`), or you can run it manually:

```bash
ssh -i ~/.ssh/google_compute_engine net2t@34.131.188.94 "cd /var/www/typo3-demo/current && php vendor/bin/typo3 database:updateschema"
```

### Pattern B: Content Updates (Pages, Text content, Settings)
If you created new pages, added content elements, or installed standard templates, these live inside the database data. You have to migrate the data itself. The safest method for a complete overwrite is dumping your local DB and importing it to production:

**Step 1:** Export your local database via DDEV
```bash
ddev export-db --file=/tmp/db.sql.gz
```

**Step 2:** Upload and import it to the remote VM
```bash
scp -i ~/.ssh/google_compute_engine /tmp/db.sql.gz net2t@34.131.188.94:/tmp/db.sql.gz

ssh -i ~/.ssh/google_compute_engine net2t@34.131.188.94 "zcat /tmp/db.sql.gz | sudo mariadb typo3_demo && cd /var/www/typo3-demo/current && php vendor/bin/typo3 cache:flush"
```

> **Warning:** Pattern B will completely overwrite the live database with your local version. Any content natively created by editors on the production site will be lost! Once your site is truly "Live", content should be generated directly on production, and only code (Pattern 1) and Schema (Pattern 3A) deployed.
