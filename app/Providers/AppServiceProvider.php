<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('unique_name_within_group_for_update', function ($attribute, $value, $parameters, $validator) {
            // $attribute: El nombre del atributo (en este caso, 'name')
            // $value: El valor del atributo ('name' en este caso)
            // $parameters: Los parámetros de la regla (tabla, columna, grupo_id, y el id de la categoría)

            list($table, $column, $group_id, $categoryId) = $parameters;

            // Verifica si el nombre es único dentro del grupo
            return DB::table($table)
                ->where($column, $value)
                ->where('group_id', $group_id)
                ->where('id', '<>', $categoryId) // Excluye el ID de la categoría que estás actualizando
                ->count() === 0;
        });
        Validator::extend('unique_name_within_group_for_create', function ($attribute, $value, $parameters, $validator) {
            list($table, $column, $group_id) = $parameters;

            // Verifica si el nombre es único dentro del grupo
            return DB::table($table)
                ->where($column, $value)
                ->where('group_id', $group_id)
                ->count() === 0;
        });
    }
}
