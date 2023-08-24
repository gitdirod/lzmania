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
        Validator::extend('unique_within_group', function ($attribute, $value, $parameters, $validator) {
            // $attribute: El nombre del atributo (en este caso, 'name')
            // $value: El valor del atributo ('name' en este caso)
            // $parameters: Los parámetros de la regla (grupo_id en este caso)

            list($table, $column, $group_id) = $parameters;

            // Verifica si el nombre es único dentro del grupo
            return DB::table($table)
                ->where($column, $value)
                ->where('group_id', $group_id)
                ->count() === 0;
        });
    }
}
