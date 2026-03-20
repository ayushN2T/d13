<?php

declare(strict_types=1);

namespace Deployer;

require 'recipe/typo3.php';

set('application', 'typo3-demo');
set('repository', 'https://github.com/ayushN2T/d13.git');
set('git_tty', false);
set('keep_releases', 5);
set('deploy_path', '/var/www/html');
set('http_user', 'www-data');
set('typo3_webroot', 'public');
set('writable_mode', 'chmod');
set('aws_public_host_pattern', 'ec2-23-20-53-135\.compute-1\.amazonaws\.com');
set('aws_public_ip_pattern', '23\.20\.53\.135');

set('shared_dirs', [
    'var',
    'public/fileadmin',
    'public/typo3temp',
]);

set('writable_dirs', [
    'var',
    'public/fileadmin',
    'public/typo3temp',
    'config/system',
]);

// Set shared files (The recipe defaults to settings.php, we also want additional.php)
set('shared_files', [
    'config/system/settings.php',
    'config/system/additional.php',
]);

host('production')
    ->setHostname('aws-typo3')
    ->setRemoteUser('ubuntu')
    ->set('branch', 'main');

desc('Prepare shared TYPO3 configuration files');
task('typo3:shared_dirs', function () {
    run('mkdir -p {{deploy_path}}/shared/config/system');
    run('mkdir -p {{deploy_path}}/shared/var');
    run('mkdir -p {{deploy_path}}/shared/public/fileadmin');
    run('mkdir -p {{deploy_path}}/shared/public/typo3temp');
    run('touch {{deploy_path}}/shared/config/system/settings.php');
    run('touch {{deploy_path}}/shared/config/system/additional.php');
    run(<<<'BASH'
if ! grep -q 'trustedHostsPattern' {{deploy_path}}/shared/config/system/additional.php; then
cat >> {{deploy_path}}/shared/config/system/additional.php <<'PHP'
$GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern'] = '^({{aws_public_host_pattern}}|{{aws_public_ip_pattern}}|127\.0\.0\.1|localhost)$';
PHP
fi
BASH);
});

desc('Fix release permissions');
task('deploy:permissions', function () {
    run('chgrp -R -f {{http_user}} {{deploy_path}}/shared/var {{deploy_path}}/shared/public/fileadmin {{deploy_path}}/shared/public/typo3temp {{release_path}}/config/system || true');
    run('chmod -R -f g+rwX {{deploy_path}}/shared/var {{deploy_path}}/shared/public/fileadmin {{deploy_path}}/shared/public/typo3temp {{release_path}}/config/system || true');
});

before('deploy:shared', 'typo3:shared_dirs');
after('deploy:vendors', 'deploy:permissions');
