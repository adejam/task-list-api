<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert(array(
            0 => array(
                'id' => 1,
                'label' => "Clean",
                'sort_order' => 1,
                'completed_at' => now(),
            ),
            1 => array(
                'id' => 2,
                'label' => 'Wash',
                'sort_order' => 2,
                'completed_at' => now(),
            ),
            2 => array(
                'id' => 3,
                'label' => 'do the Laundry',
                'sort_order' => 3,
                'completed_at' => now(),
            ),
            3 => array(
                'id' => 4,
                'label' => 'Wash the car',
                'sort_order' => 4,
                'completed_at' => now(),
            ),
        ));
    }
}
