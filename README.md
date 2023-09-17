### Configure the application

Create the database:

```
mysql -uroot -p
CREATE DATABASE div CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
quit
```

Copy and edit the `.env` file and enter your database details:

```
cp .env.example .env
```

Install the project dependencies and start the PHP server:

```
composer install

php artisan serve
```

Migrate tables with users seeders:

```
php artisan migrate --seed
```
Or refresh tables:

```
php artisan migrate:refresh --seed
```

Open [127.0.0.1:8000](127.0.0.1:8000).


### Working with the api

#Admin
POST [127.0.0.1:8000/api/admin/login](127.0.0.1:8000/api/admin/login) - Send from Postman admin 'emali' and 'passwored'

```
{
    "email": "admin@admin.com",
    "password": "password"
}
```

Take Bearer token and add in Headers Authorization key value. Content-Type value 'application/json'.

Admin can us PUT - 127.0.0.1:8000/api/requests/{id} and GET - 127.0.0.1:8000/api/requests routes.


GET [127.0.0.1:8000/api/requests](127.0.0.1:8000/api/requests}) - Get all requests. You can send as Params

dateOrder - date filter parameter

statusOrder - status filter parameter

pageSize - pagination size

page - select page after pagination



PUT [127.0.0.1:8000/api/requests/{id}](127.0.0.1:8000/api/requests/{id}}) - Update request with {id} id. Send from Postman admin 'comment'

```
{
    "comment": "Comment"
}
```

#User

POST [127.0.0.1:8000/api/user/register](127.0.0.1:8000/api/user/register) - Register new user.Send from Postman admin 'name', 'password' and 'email'

```
{
    "name": "user_name",
    "password": "user_password",
    "email": "user_email@gmail.com"
}
```


POST [127.0.0.1:8000/api/user/login](127.0.0.1:8000/api/user/login) - Send from Postman user 'emali' and 'passwored'

```
{
    "email": "user_email@gmail.com",
    "password": "user_password"
}
```

Take Bearer token and add in Headers Authorization key value. Content-Type value 'application/json'.

User can us POST - 127.0.0.1:8000/api/requests route.

POST [127.0.0.1:8000/api/requests](127.0.0.1:8000/api/requests}) - Create new request with json. Send from Postman user 'message'

```
{
    "message": "Message"
}
```
