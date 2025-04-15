# Product Management API

A RESTful API for managing products with authentication, built with Laravel and Sanctum.

## Table of Contents
- [Project Setup](#project-setup)
- [API Documentation](#api-documentation)
- [Design Choices](#design-choices)
- [Assumptions](#assumptions)

## Project Setup

### Prerequisites
- PHP 8.0+
- Composer
- MySQL
- Laravel 12.0+

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/jeffreywty97/test.git
   cd test
   ```

2. Install dependencies:
    ```bash
    composer install
    npm install
    ```

3.  Create and configure .env file:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  Set up database configuration in .env
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_name
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  Run migrations:
    ```bash
    php artisan migrate --seed
    ```
6.  Build Frontend Assets
    ```bash
    npm run build
    ```
    
7.  Start the development server:
    ```bash
    php artisan serve
    ```

## API Endpoints

### Authentication
| Endpoint       | Method | Description          |
|----------------|--------|----------------------|
| api/register   | POST   | User registration    |
| api/login      | POST   | User login           |
| api/logout     | POST   | User logout          |

### Products
| Endpoint                 | Method | Description                |
|--------------------------|--------|----------------------------|
| api/product              | GET    | List all products          |
| api/product              | POST   | Create new product         |
| api/product/{id}         | GET    | Get product details        |
| api/product/{id}         | DELETE | Delete product             |
| api/product/bulk_delete  | POST   | Bulk delete products       |

## Example Requests

**Register:** 
**Please note down the returned token**
```
curl -X POST http://localhost:8000/api/register \
  -H "Accept: application/json" \
  -d '{"name":"User","email":"user@example.com","password":"password","password_confirmation":"password"}'
```

**Login:** 
**Please note down the returned token**
```
curl -X POST http://localhost:8000/api/login \\
  -H "Accept: application/json" \\
  -d '{"email":"user@example.com","password":"password"}'
```

**List all products, Filter by Category:Optional** 
```
curl -X GET http://localhost:8000/api/product \\
  -H "Accept: application/json" \\
  -d '{"category":"category"}'
```

**Create new product**
**Use the token acquired from Register/Login to replace $TOKEN** 
```
curl -X POST http://localhost:8000/api/product \\
  -H "Accept: application/json" \\
  -H "Authorization: Bearer $TOKEN" \\
  -d '{"product_name":"product","description":"abc", "price": "5","stock": "5","category_id": "1"}'
```

**Get product details** 
```
curl -X GET http://localhost:8000/api/product/{product_id} \\
  -H "Accept: application/json" \\
```

**Delete product**
**Use the token acquired from Register/Login to replace $TOKEN** 
```
curl -X DELETE http://localhost:8000/api/product/{product_id} \\
  -H "Accept: application/json" \\
  -H "Authorization: Bearer $TOKEN" \\
```

**Bulk Delete product**
**Use the token acquired from Register/Login to replace $TOKEN** 
```
curl -X POST http://localhost:8000/api/product/bulk_delete \\
  -H "Accept: application/json" \\
  -H "Authorization: Bearer $TOKEN" \\
  -d '{"ids": [1,2,3,4,5]}'
```

## Assumptions
## Design Choices
Authentication: The API uses Sanctum for token-based authentication. The login endpoint provides a token, which must be included in the Authorization header for subsequent requests.

Soft Deletion: Products are not permanently deleted; instead, the status column is used to mark products as deleted. This allows data to be retained for audit purposes.

API Resources: The API responses are wrapped in API Resources (ProductResource) to ensure consistent formatting and easy modification in the future.

Validation: Laravel Form Requests are used for input validation, ensuring that only valid data is saved to the database.

