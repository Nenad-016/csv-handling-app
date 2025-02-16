# Product CSV API - Company Task

## 📌 About the Project

This is a Laravel-based REST API for managing products and categories. It includes CRUD operations, category-based product filtering, and CSV export functionality.

## 🚀 Features

- **CRUD operations** for products and categories (the requested ones)
- **RESTful API** with proper request validation and responses
- **Repository-Service Pattern** for cleaner architecture
- **CSV Export** for products based on category
- **Error handling and logging**

## 🛠️ Installation & Setup

### 1️⃣ Clone the Repository

```sh
git clone https://github.com/Nenad-016/csv-handling-app
cd product-csv-api
```

### 2️⃣ Install Dependencies

```sh
composer install
```

### 3️⃣ Environment Configuration

```sh
copy .env.example .env (in .env.example will be set the correct values for .env that is used in development)
php artisan key:generate
```

Set up your database credentials in the **.env** file.

### 4️⃣ Run Migrations

```sh
php artisan migrate 
```

### 4️⃣  option 1️⃣  Run Command to populate the tables in the database manualy

```sh
php artisan import:csv /path/to/your/file.csv
```

### 4️⃣  option 2️⃣  Run Seeader to populate data base automaticly, file must be named product_categories.csv and to be located at storage/app/imports/product_categories.csv

```sh
php artisan migrate --seed
```

### 5️⃣ Start the Development Server

```sh
php artisan serve
```

- The application and all of it's features are tested in Postman - and working


## 📜 API Endpoints

### 🗂️ **Categories**

| Method | Endpoint         | Description        |
| ------ | ---------------- | ------------------ |
| GET    | /categories      | Get all categories |
| GET    | /category/{id}   | Get record by id   |
| PUT    | /categories/{id} | Update a category  |
| DELETE | /categories/{id} | Delete a category  |

### 📦 **Products**

| Method | Endpoint                        | Description                        |
| ------ | ------------------------------- | ---------------------------------- |
| GET    | /products                       | Get all products                   |
| GET    | /product/{id}                   | Get one record by id               |
| PUT    | /products/{id}                  | Update a product                   |
| DELETE | /products/{id}                  | Delete a product                   |
| GET    | /products/category/{categoryId} | Get products by category           |
| GET    | /products/export/{categoryId}   | Export products to CSV by category |

## 📤 CSV Export

- Generates a CSV file for products in a selected category.
- The filename follows this format: **category\_name\_YYYY\_MM\_DD-HH\_MM.csv**
- The CSV is stored in `storage/app/exports/`.



Created by Nenad Jovanovic

