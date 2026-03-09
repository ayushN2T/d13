<?php

declare(strict_types=1);

namespace Deployer;

require 'recipe/common.php';

set('application', 'typo3-demo');
set('repository', 'git@github.com:ayushN2T/d13.git');
set('git_tty', false);
set('keep_releases', 5);
set('remote_user', 'net2t');
set('deploy_path', '/var/www/typo3-demo');
set('http_user', 'www-data');
set('writable_mode', 'chmod');
set('writable_dirs', [
    'var',
    'public/fileadmin',
    'config/system',
]);
set('shared_files', [
    'config/system/settings.php',
    'config/system/additional.php',
]);
set('shared_dirs', [
    'var',
    'public/fileadmin',
]);

host('production')
    ->setHostname('34.131.188.94')
    ->setRemoteUser('net2t')
    ->setForwardAgent(true)
    ->set('branch', 'main');

desc('Prepare shared TYPO3 directories');
task('typo3:shared_dirs', function () {
    run('mkdir -p {{deploy_path}}/shared/var');
    run('mkdir -p {{deploy_path}}/shared/public/fileadmin');
    run('mkdir -p {{deploy_path}}/shared/config/system');
    run('touch {{deploy_path}}/shared/config/system/settings.php');
    run('touch {{deploy_path}}/shared/config/system/additional.php');
});

desc('Install PHP dependencies');
task('deploy:vendors', function () {
    run('cd {{release_path}} && composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader');
});

desc('Flush TYPO3 caches if CLI is available');
task('typo3:cache:flush', function () {
    run('if [ -f {{release_path}}/vendor/bin/typo3 ]; then cd {{release_path}} && php vendor/bin/typo3 cache:flush 2>&1 || echo "TYPO3 cache:flush skipped (setup not complete yet)"; fi');
});

desc('Fix release permissions');
task('deploy:permissions', function () {
    run('chgrp -R {{http_user}} {{release_path}}');
    run('chmod -R g+rwX {{release_path}}/var {{release_path}}/public/fileadmin {{release_path}}/config/system');
});

before('deploy:shared', 'typo3:shared_dirs');
after('deploy:vendors', 'deploy:permissions');
after('deploy:symlink', 'typo3:cache:flush');
after('deploy:failed', 'deploy:unlock');

desc('Deploy the TYPO3 application');
task('deploy', [
    'deploy:info',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:symlink',
    'deploy:unlock',
    'deploy:cleanup',
]);
