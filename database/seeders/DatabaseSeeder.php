<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProductionLinesSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(DriverTableSeeder::class);
        $this->call(ProductionTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(QualityControlSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(LocationSeeder::class);

        //checklist
        $this->call(CategorySeeder::class);
        $this->call(ColumnSeeder::class);
    }
}
