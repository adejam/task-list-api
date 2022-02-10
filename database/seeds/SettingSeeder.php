<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'param' => "allow_duplicates",
                'value' => '0',
            ],
        ];
        foreach ($settings as $setting) {
            DB::table('settings')->insert([
            'param' => $setting['param'],
            'value' => $setting['value'],
        ]);
        }
    }
}
