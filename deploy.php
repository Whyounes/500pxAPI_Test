<?php 

require_once "recipe/common.php";

set('ssh_type', 'native');
set('default_stage', 'staging');
env('deploy_path', '/var/www');
env('composer_options', 'update --no-dev --prefer-dist --no-progress --no-interaction');
set('copy_dirs', [
    'app/commands',
    'app/config',
    'app/controllers',
    'app/database',
    'app/lang',
    'app/models',
    'app/src',
    'app/start',
    'app/tests',
    'app/views',
    'app/filters.php',
    'app/routes.php',
    'bootstrap',
    'public',
    'composer.json',
    'composer.lock',
    'artisan',
    '.env',
]);
// set('shared_files', ['.env']);
set('shared_dirs', [
    'app/storage/cache',
    'app/storage/logs',
    'app/storage/meta',
    'app/storage/sessions',
    'app/storage/views',
]);
set('writable_dirs', get('shared_dirs'));
set('http_user', 'www-data');

server('digitalocean', '174.138.78.215')
    ->identityFile()
    ->user('root')
    ->stage('staging');

task('deploy:upload', function() {
    $files = get('copy_dirs');
    $releasePath = env('release_path');

    foreach ($files as $file)
    {
        upload($file, "{$releasePath}/{$file}");
    }
});

task('deploy:staging', [
    'deploy:prepare',
    'deploy:release',
    'deploy:upload',
    'deploy:shared',
    'deploy:writable',
    'deploy:symlink',
    'deploy:vendors',
    'current',// print current release number
])->desc('Deploy application to staging.');

after('deploy:staging', 'success');
