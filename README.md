<p align="center">
  <img src="public/assets/readme/readme banner.png" alt="BALANGAY Banner">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.0-red" alt="Laravel 12.0">
  <img src="https://img.shields.io/badge/PHP-8.2-blue" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/TailwindCSS-4.1-teal" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Vite-7.0-purple" alt="Vite">
  <img src="https://img.shields.io/badge/License-MIT-green" alt="MIT License">
</p>

## 🧺About BALANGAY

**BALANGAY** is a comprehensive e-commerce platform dedicated to promoting and selling authentic indigenous Philippine crafts. The platform connects indigenous artisans with customers worldwide, providing a marketplace that celebrates Filipino cultural heritage while empowering local communities.

### Key Features

- **Multi-vendor Marketplace** - Sellers can register, manage products, and track orders
- **Admin Dashboard** - Complete administrative control over users, sellers, products, and content
- **Featured Content** - Showcase stories, artists, and communities
- **E-commerce System** - Full shopping cart, checkout, and order management
- **Analytics** - Track sales, orders, and performance metrics
- **Multi-guard Authentication** - Separate authentication for users, sellers, and admins
- **Community Integration** - Support for multiple indigenous tribes and communities

---

## 🧺System Architecture

### User Roles

The platform supports three distinct user roles:

1. **Customers (Users)** - Browse products, make purchases, track orders
2. **Sellers (Artisans)** - Manage products, view analytics, process orders
3. **Admins** - Platform-wide management and content moderation

### Technology Stack

**Backend:**
- Laravel 12.0 (PHP 8.2)
- PostgreSQL/MySQL Database
- Laravel Eloquent ORM
- Laravel Authentication with multiple guards

**Frontend:**
- Vite 7.0
- TailwindCSS 4.1
- Vanilla JavaScript
- Blade Templates

**Development Tools:**
- Composer (dependency management)
- NPM (frontend dependencies)
- Laravel Tinker
- PHPUnit (testing)

---

## 🧺Installation & Setup

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
- XAMPP/LAMP/MAMP (optional)

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd BALANGAY
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   ```

5. **Configure your `.env` file**
   ```env
   APP_NAME=BALANGAY
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=balangay
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

6. **Generate application key**
   ```bash
   php artisan key:generate
   ```

7. **Run migrations and seed database**
   ```bash
   php artisan migrate:fresh --seed
   ```

8. **Create storage symlink**
   ```bash
   php artisan storage:link
   ```

9. **Build frontend assets**
   ```bash
   npm run build
   # or for development with hot reload:
   npm run dev
   ```

10. **Start the development server**
    ```bash
    php artisan serve
    ```

11. **Access the application**
    - Public Site: `http://localhost:8000`
    - Seller Dashboard: `http://localhost:8000/seller/dashboard`
    - Admin Dashboard: `http://localhost:8000/admin/dashboard`

---

## 🧺Default Credentials

### Admin Access
- **Email:** `admin@balangay.com`
- **Password:** `admin123`

### Seller Accounts
- **Email:** `maria@seller.com` | **Password:** `password123`
- **Email:** `juan@seller.com` | **Password:** `password123`
- **Email:** `rosa@seller.com` | **Password:** `password123`

### Test User
- **Email:** `test@example.com`
- **Password:** `password`

---

## 🧺Project Structure

```
BALANGAY/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/           # Authentication controllers
│   │   │   ├── AdminController.php
│   │   │   ├── SellerController.php
│   │   │   ├── ProductController.php
│   │   │   ├── OrderController.php
│   │   │   ├── CartController.php
│   │   │   └── UserController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Seller.php
│   │   ├── Admin.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   ├── Cart.php
│   │   ├── Story.php
│   │   ├── Donation.php
│   │   └── FeaturedArtist.php
│   └── Providers/
├── database/
│   ├── migrations/         # Database schema
│   └── seeders/           # Sample data
├── public/
│   ├── assets/            # Images & static files
│   └── build/             # Compiled frontend assets
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/         # Admin dashboard views
│       ├── seller/        # Seller dashboard views
│       ├── components/    # Reusable Blade components
│       └── *.blade.php    # Public pages
├── routes/
│   ├── web.php           # Web routes
│   └── api.php           # API routes
└── storage/
    └── app/public/       # User uploads
```

---

## 🧺Core Features

### 1. **Customer Features**

#### Shopping Experience
- Browse products with filters (category, community, search)
- View detailed product information
- Add products to cart
- Checkout process with order summary
- View order history and tracking

#### User Profile
- Manage personal information
- Update billing and shipping addresses
- Change password
- View purchase history

### 2. **Seller Dashboard**

#### Product Management
- Create new products with images
- Edit existing products
- Delete products
- Track product approval status
- Manage inventory/stock levels
- **Product Categories:** Jewelry, Clothing, Home Decor, Accessories, Footwear, Bags, Art, Textiles

#### Order Management
- View incoming orders
- Update order status (Processing, Shipped, Delivered)
- Track order items per seller
- Filter orders by status

#### Analytics
- Total products count (approved/pending)
- Total sales amount
- Order statistics
- Revenue tracking

#### Profile Management
- Update shop information
- Upload profile picture
- Upload banner image
- Manage contact details
- Specify indigenous tribe/community

### 3. **Admin Dashboard**

#### User Management
- View all registered users
- Delete user accounts
- Monitor user activity

#### Seller Management
- Approve/reject seller registrations
- View seller verification status
- Manage seller accounts
- Delete seller accounts

#### Product Management
- Approve/reject products
- Mark products as featured
- Delete products
- Monitor product inventory
- Track product approval pipeline

#### Content Management

**Stories Tab:**
- Create/edit/delete cultural stories
- Publish/unpublish stories
- Add images and rich content
- Associate stories with tribes

**Donations Tab:**
- Create donation initiatives
- Set target amounts
- Update progress
- Track donation status (Active, Completed, Paused)
- Manage donation campaigns

**Featured Artists Tab:**
- Showcase indigenous artisans
- Set display order
- Activate/deactivate artists
- Manage artist profiles and crafts

**Featured Communities Tab:**
- Highlight indigenous communities
- Manage community information
- Display community products

#### Analytics Dashboard
- Platform-wide statistics
- Revenue tracking
- User/seller growth metrics
- Product performance data

---

## 🧺Workflow Integration

### Product Approval Workflow

```
1. Seller Creates Product → Status: 'pending'
2. Admin Reviews Product → Approve/Reject
3. Approved Products → Visible on Shop Page
4. Rejected Products → Hidden, seller notified
```

### Order Processing Workflow

```
1. Customer Places Order
2. Order Items Distributed to Respective Sellers
3. Seller Updates Status (Processing → Shipped → Delivered)
4. Customer Tracks Order
5. Order Completed
```

### Authentication Flow

```
- Users: Regular customers, auth via 'web' guard
- Sellers: Artisans, auth via 'seller' guard  
- Admins: Platform managers, auth via 'admin' guard
```

---

## 🧺Database Schema

### Core Tables

#### Users
- `id`, `full_name`, `email`, `phone_number`, `password`
- `billing_address`, `shipping_address`, `city`, `province`, `postal_code`

#### Sellers
- `id`, `artisan_name`, `email`, `phone_number`, `password`
- `indigenous_tribe`, `shop_name`, `shop_description`
- `profile_picture`, `banner_image`, `verification_status`

#### Products
- `id`, `name`, `description`, `price`, `stock`, `category`
- `seller_id`, `community`, `image`
- `approval_status` (pending/approved/rejected)
- `featured`, `is_active`

#### Orders
- `id`, `user_id`, `total_amount`, `status`
- Customer information fields
- Timestamps

#### Order Items
- `id`, `order_id`, `product_id`, `seller_id`
- `quantity`, `price`, `subtotal`
- `status` (pending/processing/shipped/delivered)

#### Stories
- `id`, `title`, `author`, `tribe`, `content`, `image`
- `published`

#### Donations
- `id`, `title`, `description`, `tribe`
- `target_amount`, `current_amount`, `status`, `image`

#### Featured Artists
- `id`, `name`, `tribe`, `craft`, `description`
- `image`, `display_order`, `is_active`

---

## 🧺API Routes

### Public APIs

```
GET  /api/products                 # List all products
GET  /api/products/search          # Search products
GET  /api/products/{id}            # Get product details
GET  /api/categories               # Get categories
GET  /api/communities/all          # List communities
GET  /api/public/stories           # Get published stories
GET  /api/public/featured-artists  # Get active featured artists
GET  /api/public/analytics         # Public analytics data
```

### User APIs (Authenticated)

```
GET  /api/user/profile             # Get user profile
POST /api/user/profile             # Update profile
POST /api/user/password            # Change password
GET  /api/cart                     # Get cart items
POST /api/cart/add                 # Add to cart
PUT  /api/cart/{id}                # Update cart item
DELETE /api/cart/{id}              # Remove from cart
GET  /api/orders                   # Get user orders
POST /api/orders/checkout          # Place order
```

### Seller APIs (auth:seller)

```
GET  /api/seller/profile                    # Get seller profile
POST /api/seller/update-profile             # Update profile
POST /api/seller/update-banner              # Update banner image
POST /api/seller/update-profile-picture     # Update profile picture
GET  /api/sellers/{sellerId}/products       # Get seller products
POST /seller/api/products                   # Create product
PUT  /seller/api/products/{id}              # Update product
DELETE /seller/api/products/{id}            # Delete product
GET  /api/seller/analytics                  # Seller analytics
GET  /api/seller/orders                     # Seller orders
PUT  /seller/api/orders/{id}/status         # Update order status
```

### Admin APIs (auth:admin)

```
GET  /admin/api/analytics                   # Admin analytics
GET  /admin/api/users                       # List users
DELETE /admin/api/users/{id}                # Delete user
GET  /admin/api/sellers                     # List sellers
POST /admin/api/sellers/{id}/status         # Update seller status
DELETE /admin/api/sellers/{id}              # Delete seller
GET  /admin/api/products                    # List all products
POST /admin/api/products/{id}/status        # Approve/reject product
POST /admin/api/products/{id}/featured      # Toggle featured
DELETE /admin/api/products/{id}             # Delete product
GET  /admin/api/stories                     # List stories
POST /admin/api/stories                     # Create story
POST /admin/api/stories/{id}                # Update story
DELETE /admin/api/stories/{id}              # Delete story
GET  /admin/api/donations                   # List donations
POST /admin/api/donations                   # Create donation
POST /admin/api/donations/{id}              # Update donation
DELETE /admin/api/donations/{id}            # Delete donation
GET  /admin/api/featured-artists            # List featured artists
POST /admin/api/featured-artists            # Create featured artist
POST /admin/api/featured-artists/{id}       # Update featured artist
DELETE /admin/api/featured-artists/{id}     # Delete featured artist
```

---

## 🧺Testing

Run the test suite:

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ExampleTest.php

# Run with coverage
php artisan test --coverage
```

---

## 🧺Available Composer Scripts

```bash
# Full setup (install, migrate, seed, build)
composer setup

# Development mode (server, queue, logs, vite)
composer dev

# Run tests
composer test
```

---

## 🧺Frontend Development

### Build Commands

```bash
# Development with hot reload
npm run dev

# Production build
npm run build
```

### Tailwind CSS
The project uses TailwindCSS 4.1 with custom configuration. Modify `tailwind.config.js` for customization.

---

## 🧺Asset Management

### Directory Structure

```
public/assets/
├── artisans/       # Featured artist images
├── donations/      # Donation initiative images
├── products/       # Product images
├── sellers/        # Seller profile/banner images
└── stories/        # Story images
```

### Upload Guidelines
- **Max file size:** 2MB
- **Allowed formats:** JPEG, PNG, JPG, GIF, WebP
- **Recommended dimensions:** 1200x800px for banners, 500x500px for products

---

## 🧺Configuration

### Authentication Guards

The system uses Laravel's multi-guard authentication:

```php
// config/auth.php
'guards' => [
    'web' => ['driver' => 'session', 'provider' => 'users'],
    'seller' => ['driver' => 'session', 'provider' => 'sellers'],
    'admin' => ['driver' => 'session', 'provider' => 'admins'],
]
```

### Session Configuration

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

---

## 🧺Deployment

### Production Checklist

1. Set `APP_ENV=production` and `APP_DEBUG=false`
2. Run `composer install --optimize-autoloader --no-dev`
3. Run `npm run build`
4. Set up proper database credentials
5. Configure proper mail driver
6. Set up queue worker: `php artisan queue:work`
7. Configure cron job for scheduled tasks
8. Enable HTTPS
9. Set up proper file permissions
10. Configure backup strategy

### Recommended Server Requirements

- PHP >= 8.2 with required extensions
- MySQL 8.0+ or PostgreSQL 13+
- Nginx or Apache web server
- SSL certificate
- 512MB+ RAM minimum
- Composer and Node.js for deployment

---

## 🧺Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 🧺License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 🧺Support & Contact

For support, email your administrator or open an issue in the repository.

---

## 🧺Acknowledgments

- Laravel Framework Team
- TailwindCSS Team
- Indigenous Filipino Artisan Communities
- All contributors to this project

---

<p align="center">
  Made with love for Philippine Indigenous Artisans
</p>
