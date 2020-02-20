##### Requirements
- DB: Postgres 9 and above
- Installed PostGIS plugin for PostgreSQL
- php 7.2 and above

##### Installation
- composer update
- php artisan migrate
- php artisan db:seed
- php artisan key:generate
- php artisan passport:install
- php artisan storage:link

#### Permissions
- chmod -R 777 storage

#### Docker
- docker exec -it app /bin/bash
- docker exec -it db /bin/bash
- docker-compose down && docker-compose up -d
- exit