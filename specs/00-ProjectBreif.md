# 📋 InterviewPrep — Vue d'ensemble

## 🎯 C'est quoi le projet ?

Une application Laravel pour préparer un entretien technique.

L'utilisateur peut :
1. Créer des **domaines** (ex: "Laravel", "MySQL", "PHP OOP")
2. Dans chaque domaine, ajouter des **concepts** (ex: "Eloquent N+1", "Migrations")
3. Pour chaque concept, écrire son **explication** avec ses propres mots
4. Marquer son niveau : **À revoir** / **En cours** / **Maîtrisé**
5. Cliquer sur un bouton pour générer **5 questions d'entretien** avec l'IA (Groq)

---

## 🏗️ Les 4 tables de la base de données

```
users  →  domains  →  concepts  →  generated_questions
```

**En français** :
- Un utilisateur a plusieurs domaines
- Un domaine a plusieurs concepts
- Un concept a plusieurs lots de questions générées par l'IA

---

## 🛠️ Outils utilisés

| Outil | Pour quoi faire |
|---|---|
| **Laravel** | Framework backend |
| **MySQL** | Base de données |
| **Groq API** | IA qui génère les questions |
| **Tailwind CSS** | Style simple |
| **Coding agent** (Claude Code) | M'aider à coder |

---

## 📅 Planning sur 5 jours

| Jour | À faire |
|---|---|
| **Lundi** | Setup, MCD/MLD, Jira, AGENTS.md |
| **Mardi** | Authentification + CRUD Domains |
| **Mercredi** | CRUD Concepts |
| **Jeudi** | Génération IA avec Groq |
| **Vendredi** | Tests, présentation, démo |

---

## 📂 Les specs

Chaque feature a son propre fichier :

```
specs/
├── 00-project-overview.md     ← Ce fichier
├── 01-authentication.md       ← Inscription / Connexion
├── 02-domains-crud.md         ← Gérer les domaines
├── 03-concepts-crud.md        ← Gérer les concepts
├── 04-ai-generation.md        ← Générer des questions avec l'IA
└── 05-bonus-features.md       ← Dashboard + extras
```