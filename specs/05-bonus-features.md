# 📋 Spec 05 — Bonus (Dashboard + Archives + Filtres)

> **Branche** : `feature/bonus`
> ⚠️ Optionnel — à faire seulement si tu as fini le reste

---

## 🎯 Le but

Trois petits bonus pour gagner des points :

1. **Dashboard** : une page d'accueil avec des statistiques
2. **Archives** : pouvoir "archiver" un concept au lieu de le supprimer
3. **Filtre combiné** : filtrer les concepts par statut **ET** difficulté en même temps

---

## ✅ Bonus 1 — Dashboard

### Page : `/dashboard`

Affiche en cartes simples :

```
┌─────────────────────────────────┐
│   Total concepts : 25           │
│   À revoir : 10                 │
│   En cours : 8                  │
│   Maîtrisés : 7                 │
└─────────────────────────────────┘

┌─────────────────────────────────┐
│   🟢 Mieux maîtrisé :           │
│      "PHP OOP" (8/8 maîtrisés)  │
└─────────────────────────────────┘

┌─────────────────────────────────┐
│   🔴 À retravailler :           │
│      "MySQL" (5 à revoir)       │
└─────────────────────────────────┘
```

**Pas de graphique**, juste des cartes avec des chiffres.

---

## ✅ Bonus 2 — Archives (Soft Delete)

### Le principe

Au lieu de **supprimer définitivement** un concept, on le **cache**.
L'utilisateur peut le restaurer plus tard.

### Pages

| URL | Sert à |
|---|---|
| `/concepts/archived` | Voir les concepts archivés |
| `POST /concepts/{id}/restore` | Restaurer un concept |
| `DELETE /concepts/{id}/force` | Supprimer **définitivement** |

### Comment ça marche techniquement

Dans Laravel, on ajoute `softDeletes()` dans la migration et `use SoftDeletes` dans le modèle.
Quand on appelle `->delete()`, Laravel met juste une date dans `deleted_at`.
Le concept est caché, mais pas vraiment supprimé.

⚠️ Soft delete **uniquement** sur les concepts, pas sur les domaines.

---

## ✅ Bonus 3 — Filtre combiné

### Sur la liste des concepts `/domains/{id}/concepts`

Deux menus déroulants :

```
[Tous les statuts ▼]  [Toutes les difficultés ▼]
```

L'user peut combiner :
- `?status=to_review` → seulement "À revoir"
- `?difficulty=senior` → seulement "Senior"
- `?status=to_review&difficulty=senior` → "À revoir" **ET** "Senior"

---

## ❌ Ce que je NE veux PAS

- Pas de graphiques Chart.js
- Pas de soft delete sur Domain (uniquement Concept)
- Pas de bouton "Vider la corbeille"
- Pas d'AJAX → simple formulaire HTML

---

## 📂 Fichiers à créer / modifier

```
app/Http/Controllers/DashboardController.php   ← nouveau
app/Models/Concept.php                          ← ajouter use SoftDeletes
app/Http/Controllers/ConceptController.php     ← ajouter archived/restore/forceDelete
resources/views/dashboard.blade.php             ← nouveau
resources/views/concepts/archived.blade.php    ← nouveau
resources/views/concepts/index.blade.php       ← ajouter le filtre combiné
```

---

## 🧪 Comment savoir que ça marche

### Dashboard
- [ ] `/dashboard` accessible après connexion
- [ ] Affiche le nombre de concepts par statut
- [ ] Affiche le domaine le mieux maîtrisé
- [ ] Affiche le domaine le plus à revoir

### Archives
- [ ] Supprimer un concept → il disparaît de la liste normale
- [ ] Il apparaît dans `/concepts/archived`
- [ ] Je peux le restaurer
- [ ] Je peux le supprimer définitivement

### Filtre combiné
- [ ] Filtrer par statut seul → marche
- [ ] Filtrer par difficulté seul → marche
- [ ] Filtrer par les deux en même temps → marche
- [ ] Les menus déroulants gardent leur valeur après filtre

---

## 🤖 Prompt pour le coding agent

```
Je débute en Laravel. Je veux ajouter 3 features bonus à mon app InterviewPrep.

Contexte :
- User → Domain → Concept → GeneratedQuestion (tout existe déjà)
- Statuts concept : to_review, in_progress, mastered
- Difficultés : junior, mid, senior

Je veux 3 choses :

1. DASHBOARD (/dashboard) :
   - Cartes simples avec des chiffres (PAS de graphiques)
   - Total concepts + compteur par statut
   - Le domaine "le mieux maîtrisé" (ratio mastered/total le plus haut)
   - Le domaine "le plus à revoir" (plus grand nombre de to_review)
   - Ajoute une relation hasManyThrough(Concept) sur le modèle User

2. SOFT DELETE sur Concept :
   - Migration déjà avec softDeletes() (déjà fait dans spec 03)
   - Ajouter use SoftDeletes au modèle
   - Page /concepts/archived avec liste des concepts supprimés
   - Bouton Restaurer + bouton Supprimer définitivement
   - Routes : GET archived, POST {id}/restore, DELETE {id}/force
   - Utiliser Concept::onlyTrashed() et withTrashed()

3. FILTRE COMBINÉ statut + difficulté :
   - Sur /domains/{id}/concepts
   - 2 selects HTML : statut et difficulté
   - Query string : ?status=...&difficulty=...
   - Utiliser when() dans le controller
   - Les selects gardent leur valeur avec @selected()

Je NE veux PAS :
- Graphiques (Chart.js, ApexCharts)
- Soft delete sur Domain
- AJAX

Donne-moi le PLAN. Je valide avant que tu codes.
```