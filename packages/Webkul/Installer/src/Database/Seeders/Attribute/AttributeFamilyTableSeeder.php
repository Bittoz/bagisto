<?php

namespace Webkul\Installer\Database\Seeders\Attribute;

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeFamilyTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @param  array  $parameters
     * @return void
     */
    public function run($parameters = [])
    {
        Schema::disableForeignKeyConstraints();

        DB::table('attribute_families')->delete();

        $defaultLocale = $parameters['default_locale'] ?? config('app.locale');

        DB::table('attribute_families')->insert([
            [
                'id'              => 1,
                'code'            => 'default',
                'name'            => trans('installer::app.seeders.attribute.attribute-families.default', [], $defaultLocale),
                'status'          => 0,
                'is_user_defined' => 1,
            ],
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
