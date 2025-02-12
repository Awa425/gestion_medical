# php artisan make:model product

# composer create-project laravel/laravel your-api-name

# php artisan make:migration create_products_table

# php artisan migrate

# php artisan make:controller ProductController

# php artisan make:migration create_products_table

# Route::resource('products', ProductController::class);

# fatal: unable to access 'https://github.com/Awa425/gestion_medical.git/': Could not resolve host: github.com

# Pour supprimer tous les console.log : 
` Chercher ca dans la recherche globale et supprimer ou remplacer par vide console\.log\(.*?\);?` 

# Indenté tous le code:
`  Sélectionnez tout le code avec Ctrl + A, puis appuyez sur Ctrl + K, suivi de Ctrl + F`

` git config --global --unset http.proxy`

# Generer la documentation du swagger
` php artisan l5-swagger:generate`
` http://localhost:8000/api/documentation#/`

# Seeder : 
` php artisan db:seed --class CategorieSeeder`
` php artisan db:seed --class TypeSeeder`
` php artisan db:seed --class RoleSeeder`
` php artisan db:seed --class ServiceSeeder`

# Pour tester manuellement une commande nom_commande ='patients:update-status', les commande se trouve dans App/console/commands
` php artisan patients:update-status`

# Build : 
` ng build --configuration production --base-href /medical/`
