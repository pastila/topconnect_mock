<?php
/*
 * This file has been generated automatically.
 * Please change the configuration for correct use deploy.
 */

require 'recipe/symfony3.php';

// Set configurations
set('repository', 'git@github.com:pastila/topconnect_mock.git');

set('shared_files', array_merge(get('shared_files'), []));
set('shared_dirs', array_merge(get('shared_dirs'), [
]));
set('writable_dirs', array_merge(get('writable_dirs'), [
]));

set('dump_assets', false);

// Configure servers
server('staging', 'staging.accurateweb.ru')
  ->user('deployer')
  ->identityFile()
  ->env('deploy_path', '/var/www/sites/topconnect_mock')
  ->env('branch', 'master');

before('deploy:symlink', 'database:migrate');

// Run tasks
after('deploy', 'success');
