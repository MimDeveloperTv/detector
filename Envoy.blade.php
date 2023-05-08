@servers(['localhost' => '127.0.0.1', 'remote' => "$user@$ip -p $port"])

@story('deploy')
    check_dir
    syncing_repository
    install_packages
{{--    set_permissions--}}
    cache_configs
{{--    migrate_database--}}
    octane_reload
@endstory

@task('check_dir', ['on' => $host])
    echo "Checking repository dir & .env existence"
    [ -d {{ $dir }} ] || exit 1;
    [ -f {{ $dir }}/.env ] || exit 1;
@endtask

@task('syncing_repository', ['on' => $host])
    echo 'Syncing repository'
    cd {{ $dir }}
    git pull
@endtask

@task('install_packages', ['on' => $host])
    echo "Installing composer packages"
    cd {{ $dir }}
    composer install --prefer-dist --no-plugins --no-scripts -q -o
    composer dump-autoload
@endtask

@task('set_permissions', ['on' => $host])
    echo "Setting permissions"
    cd {{ $dir }}
    chown -R root:www-data .
    {{-- find . -type d -exec chmod u=rwx,g=rx,o=rx '{}' \; --}}
    {{-- find . -type f -exec chmod u=rw,g=r,o=r '{}' \; --}}
    chmod -R ug+rwx ./storage
@endtask

@task('cache_configs', ['on' => $host])
    echo "Caching configs & routes"
    cd {{ $dir }}
    php artisan config:cache
    php artisan route:cache
@endtask

@task('migrate_database', ['on' => $host])
    echo "Migrating database"
    cd {{ $dir }}
    php artisan migrate --force
@endtask

@task('octane_reload', ['on' => $host])
    echo "Reloading octane server"
    cd {{ $dir }}
    php artisan octane:reload --server=swoole
@endtask
