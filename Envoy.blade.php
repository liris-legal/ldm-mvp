@servers(['develop' => ['ubuntu@3.112.199.228'],  'local' => ['tahi@192.168.1.1']])

@setup
    echo "[SETUP] environments in development server";
    $base_path              = '/home/ubuntu/LDM';
    $container              = 'liris-web';
    $work_dir               = '/var/www/html/liris';
@endsetup


@story('deploy', ['on' => ['develop']])
    git
    composer
    yarn
    docker
@endstory

@task('git')
    cd {{ $base_path }}
    @if ($branch)
        git stash
        git pull origin {{ $branch }}
    @endif
@endtask

@task('composer')
    echo "Build APP through docker"
    # docker exec {{ $container }} bash -c "cd {{ $work_dir }} && composer self-update && \
    #    composer install --no-progress --no-interaction && php artisan migrate:refresh --seed --force"
    docker exec {{ $container }} bash -c "cd {{ $work_dir }} && composer self-update && \
        composer install --no-progress --no-interaction && php artisan migrate:refresh --seed --force"
@endtask

@task('yarn')
    echo "Build frontend through yarn inside docker"
    docker exec {{ $container }} bash -c "cd {{ $work_dir }} && yarn && yarn prod"
@endtask

@task('docker')
    echo "Restart docker container"
    cd {{ $base_path }}
    docker-compose restart
@endtask
