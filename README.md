# Quick start

1. Clone repository to your disk
```
git clone https://github.com/EvgenySmekalin/maslov.git
```
2. Change directory to todomvc and install composer dependencies 
```
cd maslov
composer install
```
3. Edit config/db.php file according to your db settings

4. Run migrations
```
php yii migrate
```

5. You can create an admin using command
```
php yii create-admin -u=<username> -p=<password>
```
where <username> - admin username and <password> - his password.
It's only one place to create admin user.