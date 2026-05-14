# SMS Gateway

## Instalacja

```bash
cp .env.example .env
composer install
npm install
docker compose build --no-cache
docker compose up -d
npm run dev
docker exec -it sms-gateway-app bash
php artisan key:generate
php artisan migrate
php artisan serve --host=0.0.0.0 --port=8000
php artisan queue:work
```

frontend aplikacji: http://localhost:8000/

api aplikacji: http://localhost:8000/api/

pint: ./vendor/bin/pint

testy: ./vendor/bin/phpunit

## Wejście do kontenerów

- **Aplikacja:**
  ```bash
  docker exec -it sms-gateway-app bash
  ```
- **Baza danych:**
  ```bash
  docker exec -it sms-gateway-db bash
  ```
