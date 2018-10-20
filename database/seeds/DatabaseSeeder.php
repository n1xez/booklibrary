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
        DB::table('books')->truncate();

        $startIsbn = $this->getIsbn();
        $data = $this->generateFakeBooks($startIsbn);

        DB::table('books')->insert($data);
    }

    /**
     * @return int
     */
    private function getIsbn() : int
    {
        return DB::table('books')->max('isbn') ?? $startIsbn = 1865457216;
    }

    /**
     * @param int $startIsbn
     * @param int $quantity
     * @return array
     */
    private function generateFakeBooks(int $startIsbn, int $quantity = 1800) : array
    {
        $faker = Faker\Factory::create();
        $authors = $this->makeFakeAuthors($faker);

        $data = [];
        foreach (range(1, $quantity) as $index) {
            $data[$index]['isbn'] = $startIsbn++;
            $data[$index]['author_full_name'] =  $faker->randomElement($authors);
            $data[$index]['title'] = $faker->words(4, true);
            $data[$index]['year'] = $faker->year;
            $data[$index]['created_at'] = $faker->dateTime;
        }

        return $data;
    }

    private function makeFakeAuthors($faker, int $quantity = 100)
    {
        $authors = [];
        foreach (range(1, $quantity) as $index) {
            $authors[$index] = $faker->firstName . ' ' . $faker->lastName;
        }

        return $authors;
    }
}
