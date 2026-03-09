# First Deploy Run

Use this after:

- TYPO3 works in DDEV
- GitHub repo has the project
- server bootstrap is complete
- Nginx is configured

## Server Values

- Server IP: `34.131.188.94`
- SSH user: `net2t`
- Deploy path: `/var/www/typo3-demo`
- Repository: `git@github.com:ayushN2T/d13.git`
- Branch: `main`

## First Deploy Steps

1. Check SSH access to the VM:

```bash
ssh net2t@34.131.188.94
```

2. Check GitHub SSH access from the VM:

```bash
ssh -T git@github.com
```

3. Check Deployer locally:

```bash
vendor/bin/dep --version
```

4. Review the deploy config:

```bash
sed -n '1,240p' deploy.php
```

5. Run the first deployment:

```bash
vendor/bin/dep deploy production
```

6. Verify the release on the server:

```bash
ssh net2t@34.131.188.94
ls -la /var/www/typo3-demo
ls -la /var/www/typo3-demo/current
```

7. Verify the site in browser by IP first:

```text
http://34.131.188.94
```

## If Deploy Fails

Check:

1. GitHub SSH access on the VM
2. Nginx config and PHP-FPM status
3. file permissions for `net2t` and `www-data`
4. Composer availability on the VM
5. shared TYPO3 config files under `config/system`
