roduct Order System - Vue.js & Laravel Application
Welcome to the Product Order System! This application features a Vue.js frontend and a Laravel backend, all containerized using Docker for easy setup and deployment.

Table of Contents
Prerequisites
Installation
Configuration
Usage
Contact Information
Credits
Prerequisites
Docker installed
Docker Compose installed
Basic understanding of Vue.js, Laravel, and Docker
Installation
Clone the repository:

bash
Copy code
git clone https://github.com/your-repo/product-order-system.git
Navigate to the project directory:

bash
Copy code
cd product-order-system
Start the services using Docker Compose:

bash
Copy code
docker-compose up --build
Open your web browser and navigate to http://localhost:8080 for the Vue.js frontend and http://localhost:8000 for the Laravel backend (or adjust the ports as specified in docker-compose.yml).

Configuration
Frontend Configuration
For the Vue.js frontend, create a .env file in the frontend directory (if not already present) with your API base URL:

env
Copy code
VUE_APP_API_BASE_URL=http://localhost:8000
Backend Configuration
For the Laravel backend, create a .env file in the backend directory with the following configuration:

env
Copy code
APP_NAME=ProductOrderSystem
APP_ENV=local
APP_KEY=base64:YourAppKeyHere
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=product_order_system
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_COOKIE=session

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
Update the values as needed, especially the database credentials and mail configuration.

Docker Configuration
Dockerfile (Frontend):
Create a Dockerfile in the frontend directory:

Dockerfile
Copy code
# Stage 1: Build the Vue.js application
FROM node:16 AS build

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Serve the application
FROM nginx:alpine

COPY --from=build /app/dist /usr/share/nginx/html
EXPOSE 80
Dockerfile (Backend):
Create a Dockerfile in the backend directory:

Dockerfile
Copy code
FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip git libonig-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install


Usage
Once the services are running, you can:

Browse Products: Navigate to the Vue.js frontend to view a list of available products.
Product Details: Click on a product to view detailed information.
Add to Cart: Add products to your shopping cart.
Place Order: Proceed to checkout and place an order.
Manage Cart: View and modify items in your shopping cart.
Contact Information
For any questions or issues, please contact:

Email: your-email@example.com
Credits
This project was developed by Omar Abdelkefi.
