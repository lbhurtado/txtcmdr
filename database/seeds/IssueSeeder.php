<?php

use Illuminate\Database\Seeder;
use App\Campaign\Domain\Models\{Issue, Category};

class IssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        optional(Category::where('name', 'Mayor')->first(), function ($category) {
            tap(Issue::make([ 'code' => 'LEVI', 'name' => 'Levi Baligod']), function ($issue) use ($category) {
                $issue->category()->associate($category);
            })->save();
            tap(Issue::make([ 'code' => 'BOYING', 'name' => 'Boying Cari']), function ($issue) use ($category) {
                $issue->category()->associate($category);
            })->save();
        });
    }
}
