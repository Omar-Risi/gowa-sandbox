<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Gowa Sandbox API

This app is a local catcher for [Gowa](https://github.com/tulir/whatsmeow) WhatsApp Multi-Device
API's text-based send endpoints — the same idea as [Mailpit](https://mailpit.axllent.org/) for SMTP.
Point your app at this sandbox instead of a real Gowa server: nothing is actually delivered to
WhatsApp. Each call is simply captured and shown on the [dashboard](#dashboard), so you can develop
against the Gowa API locally without a live device. Only text message types are covered — sending
images, audio, files, stickers, and video is out of scope here. Full route definitions are in
[`docs/api.yaml`](docs/api.yaml).

**Base URL:** `http://localhost:8000/api/v1`

This is a local sandbox, so **no username/password is required** to call these routes.

### Endpoints

| Method | Path                       | Purpose                        |
|--------|-----------------------------|---------------------------------|
| POST   | `/api/v1/send/message`      | Send a text message             |
| POST   | `/api/v1/send/contact`      | Send a contact card             |
| POST   | `/api/v1/send/link`         | Send a link                     |
| POST   | `/api/v1/send/location`     | Send a location                 |
| POST   | `/api/v1/send/poll`         | Send a poll / vote              |
| POST   | `/api/v1/send/presence`     | Send presence status            |
| POST   | `/api/v1/send/chat-presence`| Send typing indicator            |

### Example

```bash
curl -X POST http://localhost:8000/api/v1/send/message \
  -H "Content-Type: application/json" \
  -d '{
        "phone": "6289685028129@s.whatsapp.net",
        "message": "selamat malam"
      }'
```

### Dashboard

Visit `/dashboard` to see every captured message: a list on the left (sender, preview, time),
details of the selected message on the right. The list refreshes automatically as new messages
are captured.

## Running with Docker

A `docker-compose.yml` is included to run the whole app (PHP, built assets, SQLite) without
installing PHP/Node locally.

```bash
docker compose up -d --build
```

The app is served on `http://localhost:8000` (override the host port with `APP_PORT=8080 docker
compose up -d`). Data is stored in a named `storage` volume, so it survives container restarts.
Migrations run automatically on startup. Stop it with `docker compose down` (add `-v` to also wipe
the stored data).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
