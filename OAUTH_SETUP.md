# OAuth Login Setup Guide

This guide will help you set up Google and Apple OAuth logins for your Laravel application.

## Installation

First, install Laravel Socialite:

```bash
composer require laravel/socialite
```

## Google OAuth Setup

### 1. Create a Google Cloud Project

- Go to [Google Cloud Console](https://console.cloud.google.com/)
- Create a new project
- Enable the Google+ API

### 2. Create OAuth 2.0 Credentials

- Go to **Credentials** → **Create Credentials** → **OAuth Client ID**
- Choose **Web Application**
- Add authorized redirect URIs:
    - `http://localhost:8000/auth/google/callback` (development)
    - `https://yourdomain.com/auth/google/callback` (production)

### 3. Add to `.env`

```env
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

## Apple OAuth Setup

### 1. Create an Apple Developer Account

- Go to [Apple Developer](https://developer.apple.com/)
- Enroll in the Apple Developer Program

### 2. Create App ID and Service ID

- Go to **Identifiers** → Create a new **App ID**
- Select **App IDs** and click the **+** button
- Fill in your app details and enable "Sign in with Apple"

### 3. Create a Service ID

- Go to **Identifiers** → **Service IDs** → **+**
- Create a new Service ID
- Enable "Sign in with Apple"
- Configure the return URLs

### 4. Create a Private Key

- Go to **Keys** → **+**
- Select "Sign in with Apple" capability
- Download the `.p8` key file (save it securely)

### 5. Add to `.env`

```env
APPLE_CLIENT_ID=your_service_id_here
APPLE_TEAM_ID=your_team_id_here
APPLE_KEY_ID=your_key_id_here
APPLE_CLIENT_SECRET=your_key_content_here  # Contents of the .p8 file
APPLE_REDIRECT_URI=http://localhost:8000/auth/apple/callback
```

## Database Migration

If you want to store OAuth provider information, run:

```bash
php artisan make:migration add_social_fields_to_users_table
```

Add this to the migration file:

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('google_id')->nullable()->unique();
    $table->string('apple_id')->nullable()->unique();
});
```

Then run:

```bash
php artisan migrate
```

## Updating the User Model

Update `app/Models/User.php` to track OAuth IDs:

```php
protected $fillable = [
    'name',
    'email',
    'password',
    'google_id',
    'apple_id',
];
```

## Testing

1. Start your development server:

```bash
php artisan serve
```

2. Visit the login page and test the Google and Apple buttons

3. You should be redirected to the OAuth provider and then back to your app

## Troubleshooting

- **"Client not found"** error: Make sure your `GOOGLE_CLIENT_ID` and `APPLE_CLIENT_ID` are correct
- **Redirect URI mismatch**: Ensure the redirect URIs in your OAuth provider settings match exactly
- **Socialite driver not found**: Make sure you've installed `laravel/socialite`

## Security Notes

- Store sensitive credentials in `.env` (never in version control)
- Use HTTPS in production
- Keep your private keys secure
- Validate email addresses from OAuth providers
