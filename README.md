# Kif

**Kif** est une application qui a pour but de générer un affichage agréable et imprimable de relevés bancaires au format QIF.

![Example graphique de génération de relevé de compte](./documentation/assets/exemple_account_generation.png "Example de génération de relevé de compte")

L'origine de ce projet est de donner la possibilité de présenter de manière lisible et agréable les relevés de comptes d'une petite association.

Le logiciel de comptabilité utilisé pour générer les données à tester s'appelle [Grisbi](https://github.com/grisbi/grisbi).

## Développement

### Préparation du projet

Il est nécessaire d'avoir la version 8.3 de PHP.

```shell
git clone https://github.com/Akipe/kif.git
cd kif
composer install
```

### Commandes

Il y a plusieurs commandes de disponibles pour vous aider lors de la phase de développement :

```shell
composer test # Exécute les test unitaires avec PHPUnit
composer check-standard # Vérifie que le code est correctement formaté avec la norme PSR12
composer fix-standard # Essaye de corriger automatiquement les incohérences de formatage
composer check-static-analyze # Vérifie le code avec l'analyseur statique PHPStan
composer fix-composer # Vérifie et corrige la mise en page du fichier composer.json
composer check-all # Réaliser un ensemble de tests, notamment ceux présenté ci-dessus, avec GrumPHP
composer example # Exécute le programme de test disponible dans le dossier "example"
```
