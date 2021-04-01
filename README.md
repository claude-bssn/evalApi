
# API sous Laravel
Claude Buisson
## Laravel

## Récupérer ce projet
Se mettre dans le dossier souhaité, puis utiliser cette commande :
```bash
git clone https://github.com/jperaudon/laravel_dwm14.git .
```
Faire une copie du ```.env.example``` et la nommer ```.env```, puis :
```bash
composer install
php artisan migrate --seed
```
# API

## CRUD


- Le Crud s'applique sur les tables authors, books et genres. 
- Les ajouts, suppressions et modifications de table pivot Genre_Book est prise en charge.
## Code HTTP et 404
- Les codes Http success sont transmis pour chaque requêtes.
- Les gestion des erreurs 404 est prise en charge.
## Pagination et search
- La pagination est fonctionnelle ainsi que les changement de page grâce au `withPath()` sur les livres.
- Le sort prend en compte les title | author_id | publication_year | pages_nb.
- Le search est fonctionnel sur les titres des livres.
- Le filtre s'applique sur les livres, par les genres.
## Postman
-  [![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/f6cd4d1f427ce5e85a4b)

## Bonus
- Documentation Swagger 
http://127.0.0.1:8000/api/documentation  
réalisé seulement sur l'index des livres.
- La validation des donées est effective sur la création et la mise à jour des livres.
- L'authentification a été réalisé avec sanctum et prend en compte la création d'un profil utilisateur, le login, le logout et la création de Token.