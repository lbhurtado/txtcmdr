<?php

use Illuminate\Database\Seeder;
use App\Campaign\Domain\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([ 'name' => 'Governor']);
        Category::create([ 'name' => 'Representative']);
        Category::create([ 'name' => 'Mayor']);
        Category::create([ 'name' => 'Vice-Mayor']);
    }
}
