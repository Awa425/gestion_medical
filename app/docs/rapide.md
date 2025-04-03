# Apres avoir cloner le projet, effectuer ces etapes suivantes:
`Renseigner le fichier .env`
# Lancer cmposer install
` composer install`
# Lanver les Seeders : 
` php artisan db:seed --class CategorieSeeder`
` php artisan db:seed --class TypeSeeder`
` php artisan db:seed --class RoleSeeder`
` php artisan db:seed --class ServiceSeeder`
# No application encryption key has been specified (Buggg).
` php artisan key:generate`
# Generer la documentation du swagger pour tester
` php artisan l5-swagger:generate`
` http://localhost:8000/api/documentation#/`



# php artisan migrate

# php artisan make:model product

# composer create-project laravel/laravel your-api-name

# php artisan make:migration create_products_table


# php artisan make:controller ProductController

# php artisan make:migration create_products_table

# Route::resource('products', ProductController::class);


# Pour supprimer tous les console.log : 
` Chercher ca dans la recherche globale et supprimer ou remplacer par vide console\.log\(.*?\);?` 

# Indenté tous le code:
`  Sélectionnez tout le code avec Ctrl + A, puis appuyez sur Ctrl + K, suivi de Ctrl + F`

` git config --global --unset http.proxy`



# Pour tester manuellement une commande crone : nom_commande ='patients:update-status', les commande se trouve dans App/console/commands
` php artisan patients:update-status`

# Build : 
` ng build --configuration production --base-href /medical/`


896F4B94-42B2-4312-B6D6-8A9CB611D6CA/20250225185325