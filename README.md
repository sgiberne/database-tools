# database-tools

Tools to help to manage database

## Installation

```bash
git clone git@github.com:sgiberne/database-tools.git
```

## Execution

### Create database
```php
php src/application.php sgiberne:database:create 'mysql:dbname=;host=mysql;port=3306' root password database_test
```
### Execute sql
```php
php src/application.php sgiberne:database:sql 'mysql:dbname=database_test;host=mysql;port=3306' root password ./tests/data/sql_test.sql
```
### Drop database
```php
php src/application.php sgiberne:database:drop 'mysql:dbname=;host=mysql;port=3306' root password database_test
```

# Todo
- manage Mysqli
- tests
