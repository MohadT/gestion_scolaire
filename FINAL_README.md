# Gestion Scolaire ERP — version SaaS multi-écoles

Cette version repart de la première source du projet et conserve les modules scolaires existants.

## Architecture

- Une `company` = un établissement scolaire.
- Le premier compte créé lors de l'inscription est `admin` de l'établissement.
- L'admin peut créer d'autres comptes : administrateur, professeur, comptable.
- Les comptes professeur et étudiant peuvent être liés aux profils correspondants.
- Les données scolaires sont isolées par `company_id`.
- Le professeur saisit les notes de ses évaluations.
- L'étudiant connecté voit ses notes.
- Le comptable voit les inscriptions et enregistre les paiements.
- Les informations de l'établissement sont utilisées dans les documents d'inscription et les bulletins.

## Installation

Conserver le fichier `.env` de l'installation locale.

```cmd
composer install
php artisan optimize:clear
php artisan migrate:fresh
php artisan serve
```

Puis ouvrir `http://127.0.0.1:8000`.

## Première utilisation

1. Ouvrir `/register`.
2. Créer l'établissement.
3. Le compte créé est l'administrateur principal.
4. Se connecter.
5. Renseigner/compléter les informations de l'établissement dans Administration > Établissement.
6. Créer les professeurs, étudiants et comptables.
7. Créer les comptes d'accès professeur/étudiant depuis leurs fiches.

## Migrations

Le projet contient 17 migrations, dont toutes les migrations historiques du projet original, la gestion des coefficients, les champs complémentaires de l'emploi du temps, le multi-tenant `companies/company_id` et les paiements.

Ne pas utiliser `composer update` pour installer cette version. Utiliser `composer install` afin de respecter `composer.lock`.
