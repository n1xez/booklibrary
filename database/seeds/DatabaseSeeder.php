<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $startIsbn = 9865457216;
        $data = [];
        foreach (range(1, 10) as $index) {
            $data[$index]['isbn'] = $startIsbn++;
            $data[$index]['author_full_name'] = $faker->lastName;
            $data[$index]['title'] = str_random(10);
            $data[$index]['year'] = $faker->randomDigit;
        }

        DB::table('books')->insert($data);
    }
}
