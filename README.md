# Mirzacles

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Laravel Version](https://img.shields.io/badge/laravel-v11.28.1-orange)](https://laravel.com)
[![Livewire Version](https://img.shields.io/badge/livewire-v3.0.0-blue)](https://laravel-livewire.com)
[![Tailwind CSS](https://img.shields.io/badge/tailwindcss-v3-blue)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/vite-v4-yellow)](https://vitejs.dev)
[![AlpineJS](https://img.shields.io/badge/alpinejs-v3-blue)](https://alpinejs.dev)
[![FontAwesome](https://img.shields.io/badge/fontawesome-v6-green)](https://fontawesome.com)
[![Sanctum](https://img.shields.io/badge/sanctum-v4.0.3-purple)](https://laravel.com/docs/8.x/sanctum)
[![Jetstream](https://img.shields.io/badge/jetstream-v3-blueviolet)](https://jetstream.laravel.com)

Mirzacles is a powerful and flexible application built using Laravel v11.28.1. It aims to provide an intuitive and robust platform for [insert application purpose, e.g., managing tasks, e-commerce, blogging, etc.].

## Features

- Robust authentication with Laravel Fortify and Sanctum
- MySQL database with efficient queue management
- Integration with third-party APIs using Guzzle
- Real-time, dynamic user interfaces with Livewire v3
- Beautiful and responsive UI with Tailwind CSS
- Faster builds and hot module replacement (HMR) with Vite
- Simple reactivity with AlpineJS
- Rich icon library with FontAwesome
- API token management with Laravel Sanctum
- Advanced authentication and user management with Jetstream
- [Add more features specific to your application]

## Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL
- Node.js and npm (for frontend assets)

### Steps

1. **Clone the repository**
   ```sh
   git clone https://github.com/yourusername/mirzacles.git
   cd mirzacles
   ```

2. **Install the dependencies**
   ```sh
   composer install
   npm install
   ```

3. **Set up the environment**
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

   Update the `.env` file with your database and other configurations.

4. **Run the migrations**
   ```sh
   php artisan migrate
   ```

5. **Seed the database (optional)**
   ```sh
   php artisan db:seed
   ```

6. **Install Livewire**
   ```sh
   composer require livewire/livewire:^3.0
   ```

7. **Install Tailwind CSS**
   ```sh
   npm install -D tailwindcss
   npx tailwindcss init
   ```

8. **Install and configure Vite**
   ```sh
   npm install -D vite laravel-vite-plugin
   ```

   Update your `vite.config.js` file:
   ```js
   import { defineConfig } from 'vite';
   import laravel from 'laravel-vite-plugin';

   export default defineConfig({
       plugins: [
           laravel({
               input: ['resources/css/app.css', 'resources/js/app.js'],
               refresh: true,
           }),
       ],
   });
   ```

9. **Configure Tailwind CSS**

   Update your `tailwind.config.js` file:
    ```js
    /** @type {import('tailwindcss').Config} */
    module.exports = {
      content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
      ],
      theme: {
        extend: {},
      },
      plugins: [],
    }
    ```

   Add the Tailwind directives to your `resources/css/app.css` file:
    ```css
    @tailwind base;
    @tailwind components;
    @tailwind utilities;
    ```

10. **Install AlpineJS**
    ```sh
    npm install alpinejs
    ```

    Update your `resources/js/app.js` to include AlpineJS:
    ```js
    import Alpine from 'alpinejs';

    window.Alpine = Alpine;

    Alpine.start();
    ```

11. **Install FontAwesome**
    ```sh
    npm install --save @fortawesome/fontawesome-free
    ```

    Include FontAwesome in your `resources/js/app.js`:
    ```js
    import '@fortawesome/fontawesome-free/css/all.css';
    ```

12. **Install Laravel Sanctum**
    ```sh
    composer require laravel/sanctum
    ```

    **Publish the Sanctum configuration and migration files:**
    ```sh
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    ```

    **Run the Sanctum migrations:**
    ```sh
    php artisan migrate
    ```

    **Add Sanctum's middleware to the api middleware group within your `app/Http/Kernel.php` file:**
    ```php
    'api' => [
        // ...
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
    ```

    **Configure Sanctum in your `config/sanctum.php` file.**

13. **Install Laravel Jetstream**
    ```sh
    composer require laravel/jetstream
    ```

    **Publish Jetstream's resources:**
    ```sh
    php artisan jetstream:install livewire
    ```

    **Install Jetstream's assets:**
    ```sh
    npm install
    npm run build
    ```

    **Run Jetstream's migrations:**
    ```sh
    php artisan migrate
    ```

14. **Build the frontend assets**
    ```sh
    npm run dev
    ```

15. **Start the development server**
    ```sh
    php artisan serve
    ```

Visit `http://localhost:8000` to access the application.

## Usage

### Livewire Components

You can create a new Livewire component using the following Artisan command:
```sh
php artisan make:livewire YourComponentName
```

Include the Livewire component in your Blade view:
```blade
<livewire:your-component-name />
```

### Tailwind CSS, Vite, AlpineJS, FontAwesome, Sanctum & Jetstream

You can use Tailwind CSS classes and FontAwesome icons in your Blade views and Livewire components to style your application. Vite will handle the building and hot reloading of your assets. AlpineJS can be used for simple reactivity. Laravel Sanctum allows you to issue API tokens to your users without the complication of OAuth. Jetstream adds robust scaffolding for authentication and user management.

Example:
```html
<div x-data="{ open: true }" class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md space-y-4">
  <h1 class="text-2xl font-bold text-gray-900">
    <i class="fas fa-magic"></i> Welcome to Mirzacles
  </h1>
  <button @click="open = !open" class="text-blue-500">
    <i :class="open ? 'fas fa-eye-slash' : 'fas fa-eye'"></i> Toggle Message
  </button>
  <p x-show="open" class="text-gray-500">Your dynamic and responsive application.</p>
</div>
```

### Testing

Run the test suite using PHPUnit:
```sh
php artisan test
```

## Contributing

Contributions are welcome! Please read the [contributing guidelines](CONTRIBUTING.md) for more information.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgements

- [Laravel](https://laravel.com)
- [Livewire](https://laravel-livewire.com)
- [Tailwind CSS](https://tailwindcss.com)
- [Vite](https://vitejs.dev)
- [AlpineJS](https://alpinejs.dev)
- [FontAwesome](https://fontawesome.com)
- [Sanctum](https://laravel.com/docs/8.x/sanctum)
- [Jetstream](https://jetstream.laravel.com)
- [Guzzle](https://github.com/guzzle/guzzle)

## Contact

For any inquiries or support, please contact [Brenton Maas](mailto:maasbrenton@gmail.com).
