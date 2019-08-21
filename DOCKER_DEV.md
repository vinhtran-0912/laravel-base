# INSTALLING WITH DOCKER GUIDE LINE
- Clone project.
- Run
```bash
composer install
```

- Create docker-compose.yml like docker-compose.yml.example and adjust as your config:
```bash
cp docker-compose.yml.example docker-compose.yml
```

- Create .env like .env.example and adjust as your config, generate key and change permission for storage:
```bash
cp .env.example .env
php artisan key:generate
sudo chmod -R 777 storage/
```
- Increase max_map_count to 262144 for fixing elastichsearch warning
```bash
sudo sysctl -w vm.max_map_count=262144
```
- Run docker:
```bash
docker-compose up -d
```