# Mini LMS Pédagogique — Laravel

Application de gestion de formations développée en Laravel. Permet à un administrateur de gérer formations, chapitres, contenus, quiz et notes. Les apprenants peuvent consulter leurs cours, passer des quiz et voir leurs résultats.

---

## Prérequis

- PHP >= 8.2
- Composer
- Node.js + npm (pour le build front-end)

---

## Installation

```bash
# 1. Cloner le projet
git clone <url-du-repo> mini-lms
cd mini-lms

# 2. Installer les dépendances PHP
composer install

# 3. Copier et configurer l'environnement
cp .env.example .env
php artisan key:generate
```

### Base de données

Le projet utilise **SQLite** par défaut (aucune installation requise).

Vérifiez que dans `.env` :
```
DB_CONNECTION=sqlite
```

Le fichier SQLite sera automatiquement créé dans `database/database.sqlite`.

```bash
# 4. Créer la base de données et insérer les données de démo
php artisan migrate:fresh --seed
```

---

## Lancer le serveur

```bash
php artisan serve
```

L'application est accessible sur **http://localhost:8000**

---

## Comptes de démonstration

| Rôle       | Email              | Mot de passe |
|------------|--------------------|--------------|
| Admin      | admin@lms.fr       | password     |
| Apprenant  | alice@lms.fr       | password     |

---

## Données de démonstration incluses

Le seeder crée automatiquement :

- **1 formation** : *Anglais — Maîtriser les verbes irréguliers*
- **2 chapitres** : Introduction + Les 10 verbes indispensables
- **3 sous-chapitres** avec contenu pédagogique HTML (dont 2 contenus marqués « Généré par IA »)
- **1 quiz** de 7 questions à choix multiple sur les verbes irréguliers
- **1 note** de démo pour l'apprenant Alice (15.5/20)
- Alice est automatiquement inscrite à la formation

---

## Fonctionnalités

### Parcours Admin (`/admin/...`)
- Dashboard avec statistiques et derniers résultats
- CRUD complet : formations, chapitres, sous-chapitres, contenus, quiz, questions/réponses, notes
- Inscription/désinscription des apprenants aux formations
- Consultation du profil complet de chaque apprenant

### Parcours Apprenant (`/apprenant/...`)
- Dashboard personnalisé (formations, quiz récents, notes)
- Navigation dans les formations auxquelles il est inscrit
- Lecture du contenu pédagogique (HTML + ressources)
- Passage des quiz à choix multiple avec calcul automatique du score
- Page de résultat avec correction complète
- Consultation de toutes ses notes avec moyenne générale

---

## Structure du projet

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # DashboardController, FormationController, ChapitreController...
│   │   └── Apprenant/      # DashboardController, FormationController, QuizController, NoteController
│   └── Middleware/
│       ├── AdminMiddleware.php
│       └── ApprenantMiddleware.php
├── Models/                 # User, Formation, Chapitre, SousChapitre, Contenu, Quiz, Question, Reponse, QuizResult, Note
database/
├── migrations/             # Toutes les migrations LMS
└── seeders/
    └── DatabaseSeeder.php  # Données de démo verbes irréguliers
resources/views/
├── layouts/app.blade.php   # Layout Bootstrap avec sidebar dynamique
├── admin/                  # Toutes les vues admin
└── apprenant/              # Dashboard, formations, quiz, notes
routes/web.php              # Routes séparées admin / apprenant avec middleware
```

---

## Schéma de base de données

```
users (role: admin|apprenant)
  └─► formation_user (pivot)
formations
  └─► chapitres
        └─► sous_chapitres
              ├─► contenus
              └─► quizzes
                    └─► questions
                          └─► reponses
quiz_results (user_id, quiz_id, score, total)
notes (user_id, formation_id, matiere, note/20)
```
