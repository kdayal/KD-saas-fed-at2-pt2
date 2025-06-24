# Joke Management Application
<a name="readme-top"></a>

This application is a web-based platform for managing and interacting with jokes, built using the Laravel framework. It features user authentication, role-based access control, joke creation and categorization, and a like/dislike system.

#### Built With

[![PHP][Php.com]][Php-url]
[![Laravel][Laravel.com]][Laravel-url]
[![Tailwindcss][Tailwindcss.com]][Tailwindcss-url]
[![Livewire][Livewire.com]][Livewire-url]
[![Spatie Laravel Permission][Spatie-Permission-shield]][Spatie-Permission-url]
[![Font Awesome][FontAwesome-shield]][FontAwesome-url]
[![Laragon][Laragon-shield]][Laragon-url]
[![Visual Studio Code][VSCode-shield]][VSCode-url]

## Definitions

| Term | Definition                                                                                                  |
|----|-------------------------------------------------------------------------------------------------------------|
| BREAD | Database operations to Browse, Read, Edit, Add and Delete data                                               |
| CRUD | More commonly used term over BREAD. Create (Add), Retrieve (Browse/Read), Update (Edit) and Delete (Delete) |
| MVC | Model-View-Controller: A software architectural pattern for implementing user interfaces. Models manage data, Views display data, and Controllers handle user input and interactions. |
| HTTP VERB | Methods indicating the desired action to be performed for a given resource (e.g., GET, POST, PUT, PATCH, DELETE). |
| API | Application Programming Interface: A set of rules and protocols for building and interacting with software applications. |
| Middleware | Software that acts as a bridge between an operating system or database and applications, especially on a network. In Laravel, it provides a convenient mechanism for filtering HTTP requests entering your application. |
| ORM | Object-Relational Mapping: A programming technique for converting data between incompatible type systems using object-oriented programming languages. Laravel uses Eloquent as its ORM. |
| PSR | PHP Standard Recommendation: A PHP specification published by the PHP Framework Interop Group. PSR-1, PSR-12, PSR-4 are coding style and autoloading standards. |

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Description

This project, the "Joke Management Application," was developed as a portfolio piece to demonstrate proficiency in building a full-stack web application using Laravel. The primary motivation was to create a functional platform incorporating common web application features such as user authentication, role-based authorization, CRUD operations for multiple resources (jokes, users, categories), and interactive elements like a like/dislike system.

The application solves the need for a centralized place to share, categorize, and rate jokes. It allows different types of users (Administrators, Staff, Clients/Ordinary Users) to interact with the system based on their assigned roles and permissions.

Through this project, I learned to:
*   Implement a robust authentication and authorization system using Laravel Breeze and Spatie Laravel Permission.
*   Design and manage database schemas using Laravel Migrations.
*   Develop CRUD functionalities for multiple resources.
*   Implement many-to-many relationships (e.g., jokes and categories).
*   Build interactive features like a like/dislike system.
*   Structure a Laravel application following MVC principles.
*   Utilize Blade templating and Tailwind CSS for the frontend.
*   Manage application state and user input with controllers and Form Requests.
*   Seed a database with initial data for development and testing.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Table of Contents

- [Description](#description)
- [Definitions](#definitions)
- [Built With](#built-with)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [Usage](#usage)
- [Features](#features)
- [Testing](#testing)
- [Deployment Notes](#deployment-notes)
- [Code Style and Commenting](#code-style-and-commenting)
- [Credits](#credits)
- [Licence](#licence)
- 

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Installation

To get this project up and running on your local machine, follow these steps:

1.  **Clone the repository:**
    ```bash
    git clone <https://github.com/kdayal/KD-saas-fed-at2-pt2.git>
    cd <KD-saas-fed-at2-pt2>
    ```

2.  **Install PHP Dependencies:**
    Ensure you have Composer installed.
    ```bash
    composer install
    ```

3.  **Install Node.js Dependencies:**
    Ensure you have Node.js and npm installed.
    ```bash
    npm install
    ```

4.  **Build Frontend Assets:**
    ```bash
    npm run build
    ```

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Configuration

1.  **Copy the Environment File:**
    ```bash
    cp .env.example .env
    ```

2.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

3.  **Edit the `.env` file:**
    Open the newly created `.env` file in your code editor. You will need to configure your database connection and other settings. Refer to your `Secrets.md` file (which should NOT be committed to Git) for sensitive details.

    **Example `.env` settings:**
    ```dotenv
    APP_NAME="Joke App"
    APP_ENV=local
    APP_KEY=base64:... # This is generated by php artisan key:generate
    APP_DEBUG=true
    APP_URL=http://localhost # Or your local development URL (e.g., http://kd-saas-fed-at2-pt2.test)

    # Database Configuration (Example for MySQL)
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name # As per your Secrets.md
    DB_USERNAME=your_database_user # As per your Secrets.md
    DB_PASSWORD=your_database_password # As per your Secrets.md

    # Mail Configuration (Important for Email Verification)
    MAIL_MAILER=log # Use 'log' for local testing to avoid sending real emails
    MAIL_HOST=mailpit # Or your mail server host
    MAIL_PORT=1025 # Or your mail server port
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
    ```

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Database Setup

1.  **Create the Database:**
    Using your database management tool (like phpMyAdmin, MySQL Workbench, or the command line), create a new database with the name specified in your `.env` file (`DB_DATABASE`). Also, ensure the database user specified in `.env` (`DB_USERNAME`) has full privileges on this database.

2.  **Run Migrations and Seed the Database:**
    This command will run all database migrations to create the necessary tables and then run the seeders to populate them with initial data (users, roles, permissions, categories, jokes).

    ```bash
    php artisan migrate:fresh --seed
    ```
    *   `migrate:fresh` drops all tables and re-runs migrations. Use `migrate --seed` if you want to run only new migrations and seed. `migrate:fresh --seed` is recommended for a clean setup from source.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Running the Application

1.  **Start the Local Development Server:**
    ```bash
    php artisan serve
    ```
    This will typically start the server at `http://127.0.0.1:8000`. If you are using a local development environment like Laragon, you might access it via a custom domain (e.g., `http://kd-saas-fed-at2-pt2.test`).

2.  **Access the Application:**
    Open your web browser and go to the URL where your application is running.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Usage

Once the application is running, you can interact with it as follows:

1.  **Registration:** New users can register for an account.
2.  **Login:** Registered users can log in. Default seeded users include:
    *   Administrator: `admin@example.com` (Password: `Password1`)
    *   Staff: `staff@example.com` (Password: `Password1`)
    *   Client: `client@example.com` (Password: `Password1`)
3.  **Dashboard:** After login, users are redirected to their dashboard.
4.  **Jokes:**
    *   View a list of jokes.
    *   View individual joke details.
    *   Add new jokes (if authorized).
    *   Edit/Delete own jokes (if authorized).
    *   Like/Dislike jokes.
    *   Search jokes by keyword or category.
    *   Manage trashed jokes.
5.  **User Management (Admin/Staff):**
    *   View, add, edit, delete users.
    *   Manage user roles.
    *   Manage trashed users.
6.  **Category Management (Admin/Staff):**
    *   View, add, edit, delete categories.
7.  **Role Management (Admin):**
    *   View, add, edit, delete roles and assign permissions to them.

**Example Screenshot:**
![user list](<Screenshot 2025-06-20 094749.png>)
![jokes list](<Screenshot 2025-06-20 094804.png>)
![manage role](<Screenshot 2025-06-20 094819.png>)
![This is what the admin login and dashboard look like.](<Screenshot 2025-06-21 133154.png>) 
![home page](<Screenshot 2025-06-21 133142.png>)

```md
![Admin Categories Page](assets/images/admin-categories-list.png)


Credits
Lecturer: Adrian Gould, North Metropolitan TAFE (GitHub Profile)
TAFE: North Metropolitan TAFE (Website)
Starter Kit: Laravel Retro Blade Starter Kit by Adrian Gould (Repo)
Font Awesome: Icons used throughout the application. (Website)
Laravel: The PHP Framework For Web Artisans. (Website)
PHP: Hypertext Preprocessor. (Website)
Tailwind CSS: A utility-first CSS framework. (Website)
Spatie Laravel Permission: Package for managing roles and permissions. (Website)
Professional README Guide: Template inspiration.

Features
The Joke Management Application includes the following features:

Jokes
Browse Jokes: All users (Guest, Registered User, Staff, Administrator) can view a list of jokes.
Retrieve/Show Joke: All users can view the details of a single joke.
Includes search by keyword and category.
Add Joke: Registered users (Client, Staff, Administrator) can add new jokes.
Edit Joke:
Users can edit their own jokes.
Staff and Administrators can edit any joke.
Delete Joke (Soft Delete):
Users can delete (move to trash) their own jokes.
Staff and Administrators can delete any joke.
Trash Management:
Users can view their own trashed jokes.
Users can recover their own jokes from trash.
Users can permanently delete their own jokes from trash.
Administrators can manage all trashed jokes.
Categorization: Jokes can be assigned multiple categories.
Likes/Dislikes: Registered users can like or dislike jokes, change their interaction, or remove it.
Users
User Self-Registration: Guests can register for a new account.
Login/Logout: Registered users can log in and log out.
Email Verification: New users need to verify their email address.
Profile Edit: Users can edit their own profile information.
User Management (Admin/Staff):
Browse Users: Administrators and Staff can view a list of users.
Add User: Administrators and Staff can add new users.
Edit User:
Administrators can edit any user.
Staff can edit Client users and their own profile.
Delete User (Soft Delete):
Administrators can delete any user (except themselves).
Staff can delete Client users.
Trash Management (Admin): Administrators can view, restore, and permanently delete users from trash.
Administration (Administrator/Staff Roles)
Role Management (Admin):
Create, Read, Edit, Delete roles.
Assign permissions to roles.
Category Management (Admin/Staff):
Create, Read, Edit, Delete categories.
User Role Assignment (Admin): Administrators can assign and remove roles from users.
Dashboard: Displays a count of total joke categories in the system.
Testing
Manual testing was performed throughout the development lifecycle to ensure all features function as expected across different user roles. This included:

Verifying CRUD operations for Users, Jokes, Roles, and Categories.
Testing role-based authorization for all actions.
Ensuring soft delete and trash management functionalities work correctly.
Validating the like/dislike system and category assignment.
Checking search and filtering functionalities.
Confirming data integrity and user experience flows.


