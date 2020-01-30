<?php


use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [];
        $faker = Faker\Factory::create('fr_FR');
        $date = $faker->unixTime('now');
        for ($i = 0; $i<100; $i++) {
            $data[]=[
                'name'=> $faker->sentence(),
                'slug'=> $faker->slug,
                'content'=>$faker->text(3000),
                'created_at'=>date('y-m-d H:i:s', $date),
                'updated_at'=>date('y-m-d H:i:s', $date)
            ];
        }
        $this->table('posts')
            ->insert($data)
            ->save();
    }
}
