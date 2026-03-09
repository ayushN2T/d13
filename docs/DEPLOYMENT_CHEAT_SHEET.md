# Deployment Management Guide

This guide covers how to deploy, roll back, and manage old releases for the `typo3-demo` application using Deployer.

## Deploying

To deploy the current `main` branch to the production GCP VM execution environment, run:

```bash
ddev exec "vendor/bin/dep deploy production"
```

## Rolling Back

If a deployment fails or introduces a bug, you can instantly revert the symlink (`current/`) back to the previously working release.

To roll back to the **previous** release:

```bash
ddev exec "vendor/bin/dep rollback production"
```

> **Note:** Rollback reverses the symlink but does *not* delete the files from the bad release—they will wait to be cleaned up automatically during your next deployment cycle.

### Rolling Back to a Specific Older Release
If you need to skip the immediate previous release and roll back to a much older release (e.g., Release `#3`), you must SSH directly into the VM and update the symlink manually:

```bash
# SSH into your VM first
ln -sfn /var/www/typo3-demo/releases/3 /var/www/typo3-demo/current
```

## Managing Release Limits & Deleting Old Releases

By default, the server only keeps the **last 5 releases**. Older releases are deleted automatically at the end of each successful deployment.

### Changing the Limit
To keep more or fewer releases, edit this line in your `deploy.php`:
```php
set('keep_releases', 5);
```

### Forcing Cleanup Manually
If you want to trigger the automatic cleanup script without deploying a new release (for example, if you lowered the limit and want to clear out disk space immediately), run:
```bash
ddev exec "vendor/bin/dep deploy:cleanup production"
```

### Deleting a Specific Release
To completely delete a specific older release manually instead of waiting for Deployer's automatic cleanup, you need to SSH into your VM and remove the folder. For example, to delete release `#4`:
```bash
# SSH into your VM first
rm -rf /var/www/typo3-demo/releases/4
```
**Warning**: Never delete the release folder that the `current` symlink is pointing to!
