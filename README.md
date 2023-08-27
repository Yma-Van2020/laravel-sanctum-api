# Laravel REST API with Sanctum

This project covers:
- Basic Routing
- Product Model & Migration
- Using the Model
- Product Controller & Methods
- Create Products & Validation
 Single Product & Resource Routes
- Update Product
- Delete Product
- Search Products
- Sanctum Setup
- Protecting Routes
- Auth Controller
- Register User & Get Token
- Logout & Delete Token
- Login User & Get Token

## Usage

Change the *.env.example* to *.env* and add your database info

For SQLite, add
```
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
```

Create a _database.sqlite_ file in the _database_ directory

```
# Run the webserver on port 8000
php artisan serve
```

## Routes

```
# Public

GET   /api/products
GET   /api/products/:id

POST   /api/login
@body: email, password

POST   /api/register
@body: name, email, password, password_confirmation


# Protected

POST   /api/products
@body: name, slug, description, price

PUT   /api/products/:id
@body: ?name, ?slug, ?description, ?price

DELETE  /api/products/:id

POST    /api/logout
```
