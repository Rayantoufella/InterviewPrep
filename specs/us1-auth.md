# US1 : Authentification (Inscription / Connexion / Déconnexion)

## Statut
✅ **Terminé** — Implémenté par Laravel Breeze

## Routes
| Méthode | URI                 | Controller@Action                                |
|---------|---------------------|-------------------------------------------------|
| GET     | /register           | RegisteredUserController@create                  |
| POST    | /register           | RegisteredUserController@store                  |
| GET     | /login              | AuthenticatedSessionController@create            |
| POST    | /login              | AuthenticatedSessionController@store             |
| POST    | /logout             | AuthenticatedSessionController@destroy         |
| GET     | /forgot-password    | PasswordResetLinkController@create              |
| POST    | /forgot-password    | PasswordResetLinkController@store               |

## Fichiers existants
- `routes/auth.php` — Routes d'auth
- `app/Http/Controllers/Auth/` — Tous les contrôleurs
- `resources/views/auth/` — Vues login, register, etc.
- `resources/views/layouts/guest.blade.php` — Layout authentification

## Vérification
```bash
php artisan route:list --path=register
php artisan route:list --path=login
```