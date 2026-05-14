# SMS Gateway

## Instalacja

```bash
cp .env.example .env
composer install
npm install
docker compose build --no-cache
php artisan key:generate
docker compose up -d
npm run dev
docker exec -it sms-gateway-app bash
php artisan migrate
php artisan serve --host=0.0.0.0 --port=8000
php artisan queue:work
```

frontend aplikacji: http://localhost:8000/

api aplikacji: http://localhost:8000/api/

swagger aplikacji: http://localhost:8000/api/docs

pint: ./vendor/bin/pint

testy: ./vendor/bin/phpunit

swagger: php artisan l5-swagger:generate

## Wejście do kontenerów

- **Aplikacja:**
  ```bash
  docker exec -it sms-gateway-app bash
  ```
- **Baza danych:**
  ```bash
  docker exec -it sms-gateway-db bash
  ```
