# Blog App

This is a simple Laravel project setup guide. Follow the steps below to get your Laravel application up and running.

## Prerequisites

Before you begin, ensure you have the following installed on your machine:

- [PHP](https://www.php.net/manual/en/install.php) (version 7.4 or later)
- [Composer](https://getcomposer.org/download/)
- [Node.js and npm](https://nodejs.org/) (for frontend dependencies)
- [MySQL](https://www.mysql.com/downloads/) or another supported database

## Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/emmo00/blog-app.git
cd blog-app
```

### Step 2: Install Dependencies

Install PHP dependencies using Composer:

```bash
composer install
```

### Step 3: Configure Environment Variables

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate an application key:

```bash
php artisan key:generate
```

### Step 4: Configure Database

Open the `.env` file and update the following lines with your database configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### Configure Cloudinary

Open the `.env` file and add your cloudinary url

```env
CLOUDINARY_URL=cloudinary://724979928357437:<your_api_secret>@drcwe987o
```

### Step 5: Run Migrations

Run the database migrations to create the necessary tables:

```bash
php artisan migrate
```

### Step 6: Seed the Database (Optional)

If you want to seed the database, run:

```bash
php artisan db:seed
```

### Step 7: Serve the Application

Start the Laravel development server:

```bash
php artisan serve
```

By default, the application will be accessible at `http://127.0.0.1:8000`.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contributing

If you wish to contribute, please fork the repository and submit a pull request.
