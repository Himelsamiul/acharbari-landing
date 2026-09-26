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

## 7. Payment Gateway (bKash / Nagad API)

Online payment live korar steps:

1. **Credentials nin:**
   - bKash → [developer.bka.sh](https://developer.bka.sh) e merchant account register kore **App Key, App Secret, Username, Password** nin
   - Nagad → merchant onboarding sesh hole **Merchant ID, Nagad Public Key, apnar Private Key** pair paben
2. **Admin panel e boshan:** `/admin/settings/payment`
   - "অনলাইন পেমেন্ট" master toggle ON
   - Gateway toggle ON + mode `Live` + credentials boshan + Save
3. **Callback URL register korun** (gateway er portal e):
   - bKash: `https://apnadomain.com/payment/callback/bkash/ORDER_CODE` (page e dekhano ache, copy koro)
   - Nagad: `https://apnadomain.com/payment/callback/nagad/ORDER_CODE`
   - `apnadomain.com` apnar real domain hobe + HTTPS lagbe
4. **Sandbox e test kore nile** mode `Sandbox` rekhe dummy order diye dekhen — payment page e jay kina
5. **Verify:** ekta real ৳1 ba ৳10 er order kore bKash/Nagad diye pay koren → order e "পরিশোধ হয়েছে ✓" + TrxID dekhabe

> Online payment bandhate chaile shudhu master toggle OFF korlei hobe — customer tokhon shudhu COD dekhbe.

## 8. Auto-Deploy (GitHub Actions — git push korlei live)

`.github/workflows/deploy.yml` — main branch e push korlei:
1. Changed file gulo FTP diye `public_html/` e upload hoy
2. Live migration automatic chole (server er `setup.php` diye)

**Ekbar setup korte hobe:**

1. cPanel → **FTP Accounts** → ekta FTP user banao (`deploy@khorak.shop`) — directory `public_html`
2. GitHub repo → **Settings → Secrets and variables → Actions** → ei 4 ta secret add koro:
   | Secret | Value |
   |---|---|
   | `FTP_SERVER` | `khorak.shop` |
   | `FTP_USERNAME` | FTP user er full name (jemon `deploy@khorak.shop`) |
   | `FTP_PASSWORD` | FTP password |
   | `SETUP_KEY` | `.env` er `APP_KEY` er shesh 16 ta character |
3. Done — ei por `git push origin main` korlei 1-2 minute e live update

> **Note:** `setup.php` ar ekhon server e rekhe o hobe — deployment er pore migration
> er jonno lagbe. Keu chalate parbe na (APP_KEY chara 403 dibe). `.env` kokhono
> upload hoy na — workflow te excluded.
