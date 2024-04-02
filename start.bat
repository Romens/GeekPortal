@ECHO OFF
::cmd /c "C:\Program Files\Docker\Docker\Docker Desktop.exe"
cmd /c "C:\Program Files\Docker\Docker\resources\dockerd --register-service"

echo "[1] Starting a Docker Swarm with Postgres ... "
:repeat
cmd /c "C:\Program Files\Docker\Docker\Docker Desktop.exe" || ( timeout /t 5 && goto :repeat )
echo " ... Docker started ... "
timeout 5m

cmd /c "C:\Program Files\Docker\Docker\Docker Desktop.exe"

docker-compose run -it php php -r "file_exists('.env') || copy('.env.dist', '.env'); "

:: down
docker-compose down --remove-orphans

:: UP
docker-compose up -d --build

:: composer install
docker-compose run -it --rm composer install --ignore-platform-reqs


:: Run laravel commands
docker-compose exec -it php php artisan migrate --seed
docker-compose exec -it php php artisan key:generate
docker-compose exec -it php php artisan passport:install

:: yarn install
docker-compose exec -w /var/www/html/frontend -it node npm install
docker-compose exec -w /var/www/html/frontend -it node yarn

:: Watch
docker-compose exec -w /var/www/html/frontend -it node yarn dev

PAUSE
