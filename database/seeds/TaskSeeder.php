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
        $datas = [
            [
                'label' => "work on backend",
                'sort_order' => 1,
            ],
            [
                'label' => "work on frontend",
                'sort_order' => 2,
            ],
            [
                'label' => "work on deployments",
                'sort_order' => 3,
            ],
            ];
        foreach ($datas as $data) {
            DB::table('tasks')->insert([
            'label' => $data['label'],
            'sort_order' => $data['sort_order'],
            'completed_at' => now(),
            'updated_at' => now(),
            'created_at' => now()
        ]);
        }
    }
}
