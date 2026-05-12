# 📋 Spec 04 — Générer des Questions avec l'IA (Groq)

> **Branche** : `feature/ai-generation`

---

## 🎯 Le but

Sur la page détail d'un concept, l'utilisateur clique sur un bouton.
→ L'IA Groq génère **5 questions d'entretien** sur ce concept.
→ Les questions sont **sauvegardées en base** puis affichées.

L'utilisateur peut aussi :
- Voir l'**historique** de toutes ses générations
- **Supprimer** un lot de questions

---

## ✅ Ce que je VEUX

### Comment ça marche en 4 étapes

1. L'user clique sur "Générer des questions" sur la page d'un concept
2. Mon backend Laravel envoie une requête à l'API Groq avec le titre + l'explication du concept
3. Groq répond avec 5 questions
4. Je sauvegarde les 5 questions en base, **puis** je les affiche

### Les routes

| URL | Sert à |
|---|---|
| `POST /concepts/{id}/generate` | Générer 5 nouvelles questions |
| `DELETE /generated-questions/{id}` | Supprimer un lot |

### La table `generated_questions`

⚠️ **Important** : on stocke les **5 questions ensemble** dans **une seule ligne** (colonne JSON), pas 5 lignes.

| Colonne | Type | Remarque |
|---|---|---|
| `id` | nombre | auto |
| `concept_id` | nombre | à quel concept appartient ce lot |
| `questions` | JSON | tableau de 5 textes |
| `created_at` / `updated_at` | dates | auto |

**Exemple de contenu de `questions`** :
```json
[
  "Qu'est-ce que le problème N+1 dans Eloquent ?",
  "Comment éviter ce problème ?",
  "Donne un exemple de code qui cause ce problème.",
  "Quelle est la différence entre with() et load() ?",
  "Comment détecter ce problème en développement ?"
]
```

### La clé API Groq

⚠️ **NE JAMAIS** mettre la clé dans le code ou sur GitHub.

Dans le fichier `.env` (jamais commit) :
```
GROQ_API_KEY=gsk_xxxxxxxxxxxxx
```

Dans `.env.example` (commit OK, vide) :
```
GROQ_API_KEY=
```

### L'appel à l'API

⚠️ **Obligatoire** : utiliser uniquement `Http::` de Laravel.
**Pas** de package externe (openai-php, groq-php...).

L'URL de Groq : `https://api.groq.com/openai/v1/chat/completions`
Le modèle à utiliser : `llama-3.3-70b-versatile`

### Affichage sur la page détail du concept

```
[Bouton : 🤖 Générer des questions d'entretien]

--- Historique des générations ---

Généré le 14/05/2026 à 10:30
1. Qu'est-ce que le problème N+1 ?
2. ...
3. ...
4. ...
5. ...
[Bouton : Supprimer ce lot]

Généré le 14/05/2026 à 09:15
1. ...
...
```

### Gestion des erreurs

Si l'API Groq ne répond pas (timeout, clé invalide, etc.) :
→ Afficher un **message d'erreur clair** à l'utilisateur
→ Surtout **PAS** de page blanche
→ L'utilisateur reste sur la même page

---

## ❌ Ce que je NE veux PAS

- Pas de package externe (openai-php, groq-php) → uniquement `Http::`
- Pas de clé API dans le code → uniquement dans `.env`
- Pas plus de 5 questions par génération
- Pas d'affichage des questions **sans** les sauvegarder d'abord
- Pas de page blanche en cas d'erreur → toujours un message
- Pas de queue/job asynchrone → tout en direct
- Pas de 1 ligne par question → 1 ligne = 1 lot de 5 questions (JSON)

---

## 📂 Fichiers à créer

```
app/Models/GeneratedQuestion.php
app/Services/GroqService.php
app/Http/Controllers/GenerationController.php
database/migrations/xxxx_create_generated_questions_table.php
config/services.php          ← à modifier (ajouter 'groq')
.env                         ← ajouter GROQ_API_KEY
.env.example                 ← ajouter GROQ_API_KEY= (vide)
resources/views/concepts/show.blade.php  ← à modifier
```

---

## 🧪 Comment savoir que ça marche

- [ ] Je vois le bouton "Générer" sur la page détail d'un concept
- [ ] Je clique → 5 questions sont créées et affichées
- [ ] Les questions sont visibles dans l'historique avec la date
- [ ] Je peux supprimer un lot
- [ ] Si je mets une mauvaise clé API → message d'erreur (pas de page blanche)
- [ ] La clé n'apparaît pas dans le code Git
- [ ] Le fichier `.env` n'est **pas** sur GitHub

---

## 🔑 Étapes pour récupérer la clé Groq

1. Aller sur https://console.groq.com
2. Créer un compte (gratuit, pas de carte bancaire)
3. Aller dans "API Keys" → "Create API Key"
4. Copier la clé (commence par `gsk_...`)
5. La coller dans `.env` :
   ```
   GROQ_API_KEY=gsk_xxxxx
   ```

---

## 🤖 Prompt pour le coding agent

```
Je débute en Laravel. Je veux ajouter une feature de génération de questions
d'entretien via l'API Groq.

Contexte :
- Modèle Concept existe (avec title et explanation)
- L'user clique sur un bouton "Générer" depuis la page détail d'un concept
- 5 questions sont générées par l'IA et sauvegardées en base

CONTRAINTES IMPORTANTES :
- Utiliser UNIQUEMENT Http:: de Laravel — PAS de package openai-php ou groq-php
- Clé API uniquement dans .env, accessible via config('services.groq.key')
- Sauvegarder en base AVANT d'afficher
- Si l'API échoue → message d'erreur clair, JAMAIS de page blanche
- 1 ligne en base = 1 lot de 5 questions (colonne JSON), pas 5 lignes

Crée :
1. Migration create_generated_questions_table :
   - id, concept_id (FK cascade), questions (JSON), timestamps

2. Modèle GeneratedQuestion :
   - belongsTo(Concept)
   - cast 'questions' => 'array'
   - fillable

3. Sur le modèle Concept, ajouter : hasMany(GeneratedQuestion)

4. Service App\Services\GroqService avec méthode :
   generateQuestions($title, $explanation) qui :
   - Appelle https://api.groq.com/openai/v1/chat/completions
   - Modèle : llama-3.3-70b-versatile
   - Token via config('services.groq.key')
   - Timeout 30s
   - Demande une réponse JSON
   - Retourne un tableau de 5 strings
   - Throw une exception si erreur

5. GenerationController :
   - generate(Concept) : appelle le service, sauvegarde, redirige avec message
   - destroy(GeneratedQuestion) : supprime + redirige

6. Routes :
   - POST /concepts/{concept}/generate
   - DELETE /generated-questions/{generation}

7. Config services.php : ajouter
   'groq' => [ 'key' => env('GROQ_API_KEY') ]

8. Mettre à jour .env.example avec GROQ_API_KEY=

9. Modifier la vue concepts/show.blade.php :
   - Ajouter le bouton "Générer"
   - Afficher l'historique avec date + 5 questions + bouton Supprimer

Je NE veux PAS :
- Package openai-php / groq-php
- Clé API dans le code
- 5 lignes en base par génération
- Page blanche en cas d'erreur

Donne-moi le PLAN. Je valide avant que tu codes.
```