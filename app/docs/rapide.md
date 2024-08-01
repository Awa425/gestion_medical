# php artisan make:model product

# php artisan make:migration create_products_table

# php artisan migrate

# php artisan make:controller ProductController

# php artisan make:migration create_products_table

# Route::resource('products', ProductController::class);

# php artisan migrate:fresh --seed --seeder=TypeSeeder

` Add foreign Key`

# php artisan make:migration add_user_id_to_products_table

Up function
Schema::table('types', function (Blueprint $table) {
$table->unsignedBigInteger('profile_id');
$table->foreign('profile_id')->references('id')->on('profiles');
});

down function
Schema::table('types', function (Blueprint $table) {
$table->dropColumn('profile_id');
});
