## Start Project

### Backend:

```bash
cd backend/
```

```bash
cp .env.example .env
```

Add variables:
*DB_DRIVER* -> PHP Driver for specific DBMS
*DB_USER* -> Your database username
*DB_PASS* -> Database Password (null by default)
*DB_NAME* -> The name of your database

Run:
```bash
composer update
```

Generate Database Schema:
```bash
php infra/bin/doctrine.php orm:schema-tool:create
```

Start the server:
```bash
php -S localhost:8080 -t public
```
