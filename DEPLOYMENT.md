# Deployment Checklist — AcharBari

Production e deploy korar age ei gulো confirm koro.

## 1. Environment (`.env`)

| Key | Local (ekhon) | Production |
|---|---|---|
| `APP_ENV` | `local` | `production` |
| `APP_DEBUG` | `true` | **`false`** (na korle stack trace public dekhbe!) |
| `APP_URL` | `http://localhost` | Real domain (sitemap/og:url e use hoy) |
| `LOG_LEVEL` | `debug` | `error` |
| `MAIL_MAILER` | `log` | Real SMTP (order confirmation mail admin e jay) |

## 2. Database

```bash
php artisan migrate --force
php artisan db:seed --force   # shudhu fresh DB hole (idempotent)
```

## 3. Cache & Optimization

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

> `config:cache` korar por `.env` change korle abar `php artisan config:clear` korte hobe.

## 4. Settings (admin panel e)

- **Brand & Contact** (`/admin/settings/brand`): phone, WhatsApp, Messenger, Facebook — sob jaygay use hoy
- **Theme** (`/admin/settings/theme`): color preset
- **SEO** (`/admin/seo`): meta title/description
- **Coupons** (`/admin/coupons`): ACHAR10 default ache — real campaign onujayi
- **Pixels** (`/admin/settings/tracking/...`): FB Pixel / GA / GTM IDs

## 5. Serve

- `public/` document root hishebe set koro (Apache/Nginx) — `php artisan serve` production e na
- HTTPS forced (og:url, sitemap URLs er jonno important)
- `storage/` ar `bootstrap/cache/` writable koro
- `php artisan storage:link` chalao — na korle product image gulo dekhabe na

## 6. Verify (deploy er pore)

- [ ] Home page load hoy
- [ ] Ekta test order dao (COD) → success page + admin e dekha jay
- [ ] `/track` e code+phone diye tracking kaj kore
- [ ] Contact number admin theke change kore dekho → footer/chat update hoy
- [ ] Facebook e link share korle thumbnail (og:image) ashe
- [ ] `https://domain/sitemap.xml` open hoy
