# 📋 Spec 01 — Authentification

> **Branche** : `feature/auth`

---

## 🎯 Le but

L'utilisateur doit pouvoir :
- Créer un compte
- Se connecter
- Se déconnecter

Sans connexion, il ne voit rien.

---

## ✅ Ce que je VEUX

### Les pages

| URL | Sert à |
|---|---|
| `/register` | S'inscrire |
| `/login` | Se connecter |
| `/logout` | Se déconnecter |

### Formulaire d'inscription
- **Nom** (min 2 lettres)
- **Email** (unique)
- **Mot de passe** (min 8 caractères)
- **Confirmation du mot de passe**

### Formulaire de connexion
- **Email**
- **Mot de passe**

### Après inscription
L'utilisateur est connecté automatiquement et envoyé sur `/dashboard`.

---

## ❌ Ce que je NE veux PAS

- Pas de "Mot de passe oublié"
- Pas de connexion Google/Facebook
- Pas de vérification d'email
- Pas de Laravel Breeze (je fais à la main pour apprendre)

---

## 📂 Fichiers à créer

```
app/Http/Controllers/AuthController.php
app/Http/Requests/RegisterRequest.php
app/Http/Requests/LoginRequest.php
resources/views/auth/register.blade.php
resources/views/auth/login.blade.php
```

> La table `users` existe déjà dans Laravel, pas besoin de la créer.

---

## 🧪 Comment savoir que ça marche

- [ ] Je peux créer un compte
- [ ] Email déjà pris → message d'erreur affiché
- [ ] Mot de passe trop court → message d'erreur affiché
- [ ] Après inscription, je suis connecté
- [ ] Je peux me déconnecter
- [ ] Si pas connecté et j'essaie `/domains` → redirection vers `/login`

---

## 🤖 Prompt pour le coding agent

```
Salut, je débute en Laravel. Je veux un système simple d'inscription/connexion
SANS Laravel Breeze.

Besoins :
- Page /register : nom, email, password, confirmation
- Page /login : email, password
- Bouton déconnexion
- Après inscription → connecté + envoyé sur /dashboard
- Pages protégées → si pas connecté, renvoyer sur /login

Crée :
1. AuthController avec : showRegister, register, showLogin, login, logout
2. Form Requests : RegisterRequest et LoginRequest
3. Vues Blade simples (Tailwind) : register et login
4. Routes dans web.php

Je NE veux PAS :
- Breeze, Jetstream, Fortify
- "Mot de passe oublié"
- Validation JavaScript
- Vérification email

Donne-moi d'abord le PLAN (liste des fichiers + rôle).
Je valide avant que tu écrives le code.
```