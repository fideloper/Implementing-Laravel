<?php

class StatusesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('statuses')->delete();

        Status::create(array(
            'status' => 'Published',
            'slug' => 'published',
        ));

        Status::create(array(
            'status' => 'Draft',
            'slug' => 'draft',
        ));
    }

}