# Vue.js & Laravel Tasks Management Project

This project is a Tasks management application built using Vue.js for the frontend and Laravel for the backend API. It allows users to register, login, and manage their tasks efficiently.

# Features

- User registration and authentication
- Tasks management (create, delete, update, view, completion)
- Dashboard displaying total tasks, total completed tasks, and total no completed tasks

# Prerequisites

Before running this project, ensure you have the following installed:
- Node.js
- npm or yarn
- Composer
- php : ^7.3|^8.0
- laravel ^8.75
- MySQL

# Installation

- Clone the repository :
  git clone https://github.com/DevanasDeveloper/TODOLIST-CHALLENGE.git
- Navigate to the project directory :
  cd TODOLIST-CHALLENGE
- Navigate to the backend directory :
  cd backend
- Install PHP dependencies :
  composer install
- create new database named for example tasks or todos
- Copy .env.example to .env and update the database configuration
- generate application key :
  php artisan key:generate
- Migrate database :
  php artisan migrate
- Navigate to the frontend directory :
npm install   or   yarn install

# Usage

- Serve the Laravel application :
  php artisan serve
- Serve the vue application :
  npm run serve   or   yarn
