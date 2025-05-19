# JuaKali E-Commerce Platform

Welcome to the **JuaKali E-Commerce Platform**, a web application designed to empower Kenyan artisans by providing a marketplace to showcase and sell their crafts. Built with PHP, MySQL, and Bootstrap, this platform supports user authentication, product management, and artisan-specific features.

---

## Overview

JuaKali (Swahili for "fierce sun" or "hardworking") aims to connect artisans with customers, featuring:

- User and artisan registration/login  
- Product upload and approval system  
- Artisan dashboards and profile management  
- Order tracking and cart functionality  

The project is in active development, targeting a **Phase 5 deployment on HostPoa between June 2–4, 2025**.

---

## Features

- **User Management:** Registration, login, and account management  
- **Artisan Hub:** Dedicated index, login, signup, dashboard, and options pages  
- **Product Management:** Upload products with images, pending admin approval  
- **E-Commerce:** Cart, orders, and ratings system  
- **Responsive Design:** Optimized for desktop and mobile using Bootstrap  

---

## Prerequisites

- **Web Server:** Apache (e.g., XAMPP for local development)  
- **PHP:** Version 7.4 or higher  
- **MySQL:** Version 5.7 or higher  
- **Composer:** Optional, for dependency management  
- **Node.js and npm:** Optional, for front-end builds (if expanded)  

---

## Installation

### Clone the Repository
```bash
git clone https://github.com/colloceo/juakali.git
cd juakali
````

### Set Up the Environment

1. Install XAMPP (or your preferred stack) and start Apache and MySQL services.
2. Create the database:

```sql
CREATE DATABASE juakali_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Configure Database

1. Import the schema from `database/schema.sql` (create this file if not present):

```sql
-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    is_artisan TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Artisans Table
CREATE TABLE artisans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    bio TEXT,
    location VARCHAR(100),
    image_url VARCHAR(255) DEFAULT NULL,
    average_rating DECIMAL(3, 2) DEFAULT 0.00,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Products Table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    artisan_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255) DEFAULT NULL,
    status VARCHAR(20) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (artisan_id) REFERENCES artisans(id) ON DELETE CASCADE
);

-- Cart Table
CREATE TABLE cart (
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    PRIMARY KEY (user_id, product_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Orders Table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(50),
    delivery_option VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order Items Table
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Ratings Table
CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    artisan_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (artisan_id) REFERENCES artisans(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

2. Update `config.php` with your database credentials:

```php
<?php
$host = 'localhost';
$db_name = 'juakali_db';
$username = 'root';
$password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
```

### Create Uploads Directory

```bash
mkdir uploads
chmod 755 uploads
```

### Run the Application

Access the platform in your browser at:
`http://localhost/new/juakali/index.php`

---

## Usage

* **User Flow:** Register or log in at `index.php`, browse products, and add to cart.
* **Artisan Flow:** Visit `artisan-index.php`, sign up or log in via `artisan-signup.php` or `artisan-login.php`, and manage products via `artisan-dashboard.php` or `artisan-options.php`.
* **Admin Actions:** Approve products (to be implemented in a future admin panel).

---

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature-name`)
3. Commit your changes (`git commit -m "Description"`)
4. Push to the branch (`git push origin feature-name`)
5. Open a pull request

Please adhere to the following:

* Follow PHP PSR-12 coding standards
* Write clear commit messages
* Test changes locally before submitting

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## Roadmap

* **Phase 2 (May 19–23, 2025):** Complete artisan features (index, login, signup, dashboard, options)
* **Phase 3 (May 24–June 1, 2025):** Add admin panel for product approval
* **Phase 5 (June 2–4, 2025):** Deploy to HostPoa

---

## Contact

For issues or questions, open an issue on this repository or contact the project maintainer at **\[colooceo@gmailcom](mailto:collooceo@gmail.com]**.

---

*Last updated: May 19, 2025*

