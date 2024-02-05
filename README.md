<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## API Boilerplate Using Laravel 10

This boilerplate help to create common API such as Authentication, Role - Permissions, and Master User.

API Endpoint in this boilerplate :

<ol>
    <li>
      <p>Authentication</p>
      <ul>
        <li>GET: /profile (Get current profile logged in user) </li>
        <li>POST: /login (Standard login with email and password)</li>
        <li>POST: /login/google (Login with google)</li>
        <li>POST: /logout (Logout)</li>
      </ul>
    </li>
    <li>
      <p>User</p>
      <ul>
        <li>GET: /user (Get all user - paginated) </li>
        <li>GET: /user/{user} (Get user by ID)</li>
        <li>PUT: /user/{user} (Update user by ID)</li>
        <li>POST: /user (Create user)</li>
        <li>POST: /user/sync/role (Syncronize roles to user)</li>
        <li>POST: /user/sync/permission (Syncronize direct permissions to user)</li>
      </ul>
    </li>
    <li>
      <p>Role</p>
      <ul>
        <li>GET: /role (Get all role - paginated) </li>
        <li>GET: /role/{role} (Get role by ID)</li>
        <li>PUT: /role/{role} (Update role by ID)</li>
        <li>POST: /role (Create role)</li>
        <li>DELETE: /role/{role} (Delete role by ID)</li>
        <li>POST: /role/sync/permission (Syncronize permissions to role)</li>
      </ul>
    </li>
    <li>
      <p>Permission</p>
      <ul>
        <li>GET: /permission (Get all permission - paginated) </li>
        <li>GET: /permission/{permission} (Get permission by ID)</li>
        <li>PUT: /permission/{permission} (Update permission by ID)</li>
        <li>POST: /permission (Create permission)</li>
        <li>DELETE: /permission/{permission} (Delete permission by ID)</li>
      </ul>
    </li>
</ol>

<!-- GETTING STARTED -->

## Getting Started

Before you run on your machine, make sure the following requirements are ready

### Prerequisites

The Laravel framework has a few system requirements. You should ensure that your web server has the following minimum PHP version and extensions:

-   PHP >= 8.1
-   Ctype PHP Extension
-   cURL PHP Extension
-   DOM PHP Extension
-   Fileinfo PHP Extension
-   Filter PHP Extension
-   Hash PHP Extension
-   Mbstring PHP Extension
-   OpenSSL PHP Extension
-   PCRE PHP Extension
-   PDO PHP Extension
-   Session PHP Extension
-   Tokenizer PHP Extension
-   XML PHP Extension

[Or you can find here for system requirements](https://laravel.com/docs/10.x/deployment#server-requirements)

### Installation

1. Clone repo
    ```sh
    git clone https://github.com/tebeiksan/laravel_api_boilerplate.git
    ```
2. Install composer package
    ```sh
    composer install
    ```
3. Create `.env` file
    ```sh
    cp .env.example .env
    ```
4. Generate APP_KEY
    ```sh
    php artisan key:generate
    ```
5. Generate JWT KEY
    ```sh
    php artisan jwt:secret
    ```
6. Setup your DB configuration in `.env` file
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    ```
7. Migrate DB and Seed
    ```sh
    php artisan migrate:fresh --seed
    ```
8. Run server
    ```sh
    php artisan serve
    ```

9. Try login with basic login

    ```
    Full Access Ability
    email : admin@example.com
    password : password

    Minimum Access Ability
    email : user@example.com
    password : password
    ```

<!-- CONTRIBUTING -->

## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<!-- LICENSE -->

## License

Distributed under the MIT License. See `LICENSE.txt` for more information.

<!-- CONTACT -->

## Contact

Tubagus Iksan - [@tebeiksan](https://www.instagram.com/tebeiksan/)

<!-- ACKNOWLEDGMENTS -->

## Acknowledgments

-   [JWT Auth](https://github.com/PHP-Open-Source-Saver/jwt-auth)
-   [Laravel Permissions by Spatie](https://spatie.be/index.php/docs/laravel-permission/v6/introduction)
-   [Laravel API Resources](https://laravel.com/docs/10.x/eloquent-resources)
-   [Laravel Policies](https://laravel.com/docs/10.x/authorization#creating-policies)
-   [Google API Client](https://googleapis.github.io/google-api-php-client/main/)
