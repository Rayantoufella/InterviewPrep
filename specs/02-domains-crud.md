# 📋 Spec 02 — Gestion des Domaines (CRUD)

> **Feature** : CRUD complet pour les domaines techniques
> **User Stories** : US2, US3, US4
> **Branche Git** : `feature/domains-crud`
> **Coding agent mode** : Plan → Build

---

## 🎯 Objectif

Permettre à l'utilisateur connecté de créer, lister, modifier et supprimer ses domaines techniques (ex: "Laravel ORM", "PHP OOP", "MySQL"). Chaque domaine affiche un **compteur de progression** (concepts maîtrisés / total).

---

## ✅ Ce que je VEUX

### Routes (Resource Controller)
| Méthode | URL | Nom | Action |
|---|---|---|---|
| GET | `/domains` | `domains.index` | Liste tous les domaines de l'user |
| GET | `/domains/create` | `domains.create` | Formulaire création |
| POST | `/domains` | `domains.store` | Sauvegarder nouveau domaine |
| GET | `/domains/{domain}/edit` | `domains.edit` | Formulaire édition |
| PUT | `/domains/{domain}` | `domains.update` | Mettre à jour |
| DELETE | `/domains/{domain}` | `domains.destroy` | Supprimer |

> Génère avec : `php artisan make:controller DomainController --resource --model=Domain`

### Table `domains`
```php
Schema::create('domains', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('name');
    $table->string('color', 20); // ex: 'red', 'blue', 'green'
    $table->timestamps();
});
```

### Modèle `Domain`
- Relation : `belongsTo(User::class)`
- Relation : `hasMany(Concept::class)`
- Fillable : `['user_id', 'name', 'color']`

### Form Request : `DomainRequest`
- `name` : string, requis, min 2, max 100
- `color` : requis, in:red,blue,green,yellow,purple,gray,orange

### Liste (US2)
- Affiche **uniquement les domaines de l'user connecté** : `auth()->user()->domains`
- Pour chaque domaine :
  - Nom + badge coloré (selon `color`)
  - **Compteur** : `X / Y concepts maîtrisés`
- **Eager loading** pour éviter N+1 :
  ```php
  Domain::withCount([
      'concepts',
      'concepts as mastered_count' => fn($q) => $q->where('status', 'mastered')
  ])->get();
  ```

### Sécurité (Policy ou Gate)
- Un user ne peut **PAS** voir/modifier/supprimer un domaine qui ne lui appartient pas
- Utiliser **Policy** : `DomainPolicy` avec méthodes `view`, `update`, `delete`
- OU vérification manuelle dans controller : `abort_if($domain->user_id !== auth()->id(), 403)`

### Suppression
- `cascadeOnDelete` sur la FK → supprimer un domaine supprime ses concepts
- Confirmation JS simple : `onclick="return confirm('Sûr ?')"`

---

## ❌ Ce que je NE veux PAS

- ❌ Pas de pagination (peu de domaines par user)
- ❌ Pas de tri / recherche pour l'instant
- ❌ Pas de partage de domaines entre users
- ❌ Pas de soft delete sur domains (seulement sur concepts en bonus)
- ❌ Pas de couleur en hexadécimal libre — **liste fermée** (red/blue/green/yellow/purple/gray/orange)
- ❌ Pas de logique métier dans les vues — utilise des accessors / scopes
- ❌ Pas de requête dans une boucle Blade (N+1)

---

## 🧪 Critères d'acceptation

- [ ] CRUD complet fonctionnel (create, read, update, delete)
- [ ] Liste affiche compteur `mastered / total` correctement
- [ ] Badge de couleur affiché correctement
- [ ] User A ne voit pas les domaines de User B
- [ ] Tentative d'accès à un domaine d'un autre user → 403 ou 404
- [ ] Validation : name min 2 → erreur affichée
- [ ] Form Request `DomainRequest` créé et utilisé dans store + update
- [ ] **Zéro N+1** vérifié avec Debugbar (1-2 requêtes max sur `/domains`)
- [ ] Suppression d'un domaine supprime ses concepts (cascade)

---

## 🗂️ Structure de fichiers attendue

```
app/
├── Models/
│   └── Domain.php
├── Http/
│   ├── Controllers/
│   │   └── DomainController.php
│   ├── Requests/
│   │   └── DomainRequest.php
│   └── Policies/
│       └── DomainPolicy.php
database/
└── migrations/
    └── 2026_05_12_xxxxxx_create_domains_table.php
resources/views/domains/
├── index.blade.php
├── create.blade.php
└── edit.blade.php
```

---

## 🤖 Prompt pour coding agent (mode Plan)

```
Tu vas implémenter le CRUD complet des Domaines pour une app Laravel.

Contexte :
- User est déjà authentifié (auth Laravel native déjà en place)
- Table users existe déjà
- Relations à respecter : User hasMany Domain, Domain hasMany Concept

Crée :
1. Migration create_domains_table : id, user_id (FK cascade), name (string), color (string), timestamps
2. Modèle Domain avec relations belongsTo(User) et hasMany(Concept), fillable
3. Form Request DomainRequest : name (min 2, max 100), color (in:red,blue,green,yellow,purple,gray,orange)
4. DomainPolicy : viewAny/view/create/update/delete avec check user_id === auth()->id()
5. DomainController (resource) avec eager loading withCount pour éviter N+1
6. Vues Blade : index (avec compteur mastered/total et badge couleur), create, edit
7. Routes resource dans web.php protégées par middleware auth

Contraintes :
- ZÉRO N+1 — utilise withCount avec closure pour mastered_count
- Pas de pagination
- Couleurs limitées à une liste fermée (pas de hex libre)
- Form Request OBLIGATOIRE pour validation

Donne-moi d'abord le PLAN détaillé étape par étape, puis attends ma validation AVANT de générer le code.
```