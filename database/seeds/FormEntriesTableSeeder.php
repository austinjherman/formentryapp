
<?php

use Illuminate\Database\Seeder;

class FormEntriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 10 users using the user factory
        factory(App\FormEntry::class, 50265)->create();
    }
}