# 📋 Spec 02 — Gérer les Domaines

> **Branche** : `feature/domains-crud`

---

## 🎯 Le but

L'utilisateur veut créer des "boîtes" pour ranger ses concepts par sujet.

**Exemples de domaines** :
- "Laravel ORM"
- "PHP OOP"
- "MySQL"
- "API REST"

Chaque domaine a :
- Un **nom**
- Une **couleur** (pour le badge)

---

## ✅ Ce que je VEUX

### Les pages

| URL | Sert à |
|---|---|
| `/domains` | Voir tous mes domaines |
| `/domains/create` | Formulaire pour ajouter un domaine |
| `/domains/{id}/edit` | Formulaire pour modifier un domaine |

### La table `domains`

| Colonne | Type | Remarque |
|---|---|---|
| `id` | nombre | auto |
| `user_id` | nombre | à qui appartient le domaine |
| `name` | texte | ex: "Laravel" |
| `color` | texte | ex: "red", "blue" |
| `created_at` / `updated_at` | dates | auto |

### Sur la page liste `/domains`

Pour chaque domaine, on voit :
- Son **nom**
- Son **badge coloré**
- Combien de concepts il contient
- Combien sont **maîtrisés**

Exemple visuel :
```
🔴 Laravel ORM      → 5 concepts (2 maîtrisés)
🔵 PHP OOP          → 8 concepts (8 maîtrisés)
🟢 MySQL            → 3 concepts (0 maîtrisés)
```

### Validation du formulaire
- **Nom** : obligatoire, entre 2 et 100 caractères
- **Couleur** : doit être dans la liste : red, blue, green, yellow, purple, gray, orange

### Sécurité
L'utilisateur ne voit que **ses propres domaines**. Pas ceux des autres.

---

## ❌ Ce que je NE veux PAS

- Pas de pagination
- Pas de recherche
- Pas de couleur libre (uniquement la liste fermée)
- Pas de partage de domaines entre utilisateurs

---

## 📂 Fichiers à créer

```
app/Models/Domain.php
app/Http/Controllers/DomainController.php
app/Http/Requests/DomainRequest.php
app/Http/Policies/DomainPolicy.php
database/migrations/xxxx_create_domains_table.php
resources/views/domains/index.blade.php
resources/views/domains/create.blade.php
resources/views/domains/edit.blade.php
```

---

## 🧪 Comment savoir que ça marche

- [ ] Je peux créer un domaine
- [ ] Je peux modifier un domaine
- [ ] Je peux supprimer un domaine
- [ ] Je vois le badge coloré sur la liste
- [ ] Je vois le compteur "X concepts (Y maîtrisés)"
- [ ] Un autre utilisateur ne peut pas voir mes domaines
- [ ] Si je supprime un domaine → ses concepts sont supprimés aussi
- [ ] Nom trop court → message d'erreur

---

## 🤖 Prompt pour le coding agent

```
Je débute en Laravel. Je veux gérer des "Domaines" (catégories de concepts techniques).

Contexte :
- Auth Laravel déjà en place
- Un user a plusieurs domaines (User hasMany Domain)
- Un domaine a plusieurs concepts (Domain hasMany Concept) — Concept viendra après

Crée :
1. Migration create_domains_table :
   - id, user_id (FK vers users, cascade delete), name, color, timestamps
2. Modèle Domain :
   - belongsTo(User)
   - hasMany(Concept)
   - fillable : user_id, name, color
3. Form Request DomainRequest :
   - name : min 2, max 100
   - color : doit être dans red,blue,green,yellow,purple,gray,orange
4. DomainPolicy :
   - L'utilisateur ne peut voir/modifier/supprimer QUE ses propres domaines
5. DomainController (resource) :
   - index : afficher MES domaines avec compteur "concepts total" et "concepts maîtrisés"
     → utilise withCount pour éviter les requêtes N+1
   - create, store, edit, update, destroy
6. Vues Blade simples (Tailwind) :
   - index : tableau avec badge couleur + compteur
   - create / edit : formulaire avec champ texte + select couleur

Je NE veux PAS :
- Pagination
- Recherche
- Couleurs libres (uniquement la liste)
- Requêtes N+1

Donne-moi d'abord le PLAN. Je valide avant que tu codes.
```