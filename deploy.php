<?php

declare(strict_types=1);

namespace Deployer;

require 'recipe/typo3.php';

set('application', 'typo3-demo');
set('repository', 'git@github.com:ayushN2T/d13.git');
set('git_tty', false);
set('keep_releases', 5);
set('remote_user', 'net2t');
set('deploy_path', '/var/www/typo3-demo');
set('http_user', 'www-data');
set('writable_mode', 'chmod');

// Append any additional writable directories not covered by the default recipe
add('writable_dirs', [
    'config/system',
]);

// Set shared files (The recipe defaults to settings.php, we also want additional.php)
set('shared_files', [
    'config/system/settings.php',
    'config/system/additional.php',
]);

host('production')
    ->setHostname('34.131.188.94')
    ->setRemoteUser('net2t')
    ->setForwardAgent(true)
    ->set('branch', 'main');

desc('Prepare shared TYPO3 configuration files');
task('typo3:shared_dirs', function () {
    run('mkdir -p {{deploy_path}}/shared/config/system');
    run('touch {{deploy_path}}/shared/config/system/settings.php');
    run('touch {{deploy_path}}/shared/config/system/additional.php');
});

desc('Fix release permissions');
task('deploy:permissions', function () {
    run('chgrp -R -f {{http_user}} {{release_path}} || true');
    run('chmod -R -f g+rwX {{release_path}}/var {{release_path}}/public/fileadmin {{release_path}}/config/system || true');
});

before('deploy:shared', 'typo3:shared_dirs');
after('deploy:vendors', 'deploy:permissions');
