@servers(['develop' => ['ubuntu@54.238.212.147'],  'local' => ['tahi@192.168.1.1']])

@setup
    echo "[SETUP] path in development server";
    $base_path              = '/home/ubuntu/liris';

    echo "[SETUP] docker container in development server";
    $container              = 'liris-php72';

    $work_dir          = '/var/www/html/liris';
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
    docker exec {{ $container }} bash -c "cd {{ $work_dir }} && composer self-update && composer install --no-progress --no-interaction"
@endtask

@task('yarn')
    echo "Build Vuejs frontend through docker"
    docker exec {{ $container }} bash -c "cd {{ $work_dir }} && yarn && yarn prod"
@endtask

@task('docker')
    echo "Restart docker container"
    cd {{ $base_path }}
    docker-compose restart
@endtask
