# Mini LMS Pédagogique — Laravel

Application de gestion de formations développée en Laravel 12. Un admin gère les formations, chapitres, quiz et notes. Les apprenants consultent leurs cours et passent des quiz.

---

## Prérequis

- PHP >= 8.2
- Composer
- Node.js >= 18
- SQLite (inclus dans PHP)

---

## Installation

```bash
# 1. Cloner le projet
git clone https://github.com/Saadid35/mini-lms.git mini-lms
cd mini-lms

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JavaScript
npm install

# 4. Copier et configurer l'environnement
cp .env.example .env
php artisan key:generate
```

> ⚠️ Dans le fichier `.env`, ajouter votre clé API OpenRouter :
> ```
> OPENROUTER_API_KEY=sk-or-v1-votre-cle-ici
> ```
> Créer un compte et obtenir une clé sur [openrouter.ai](https://openrouter.ai) (compte pay-as-you-go, minimum ~5$)

```bash
# 5. Créer le fichier SQLite
# Windows (PowerShell) :
New-Item -Path database/database.sqlite -ItemType File
# Mac / Linux :
touch database/database.sqlite

# 6. Migrations + données de démo
php artisan migrate:fresh --seed
```

---

## Lancer le serveur

Ouvrir **deux terminaux** :

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

L'application est accessible sur **http://localhost:8000**

---

## Comptes de démonstration

| Rôle      | Email          | Mot de passe |
|-----------|----------------|--------------|
| Admin     | admin@lms.fr   | password     |
| Apprenant | alice@lms.fr   | password     |
