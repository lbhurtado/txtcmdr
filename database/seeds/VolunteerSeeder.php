<?php

use Illuminate\Database\Seeder;
use App\Campaign\Domain\Models\Area;
use App\Campaign\Domain\Models\Issue;
use App\Campaign\Domain\Models\Group;
use App\Missive\Domain\Models\Contact;
use App\Campaign\Domain\Models\Campaign;
use App\Campaign\Domain\Models\Category;
use App\Campaign\Imports\VolunteersImport;

class VolunteerSeeder extends Seeder
{
    protected $spreadsheet = 'spreadsheets/volunteers.xlsx';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group_nodes = [
            'HQ.CORE',
            'HQ.VOLUNTEER',
            'HQ.WATCHER',
            'HQ.VOTER',
        ];

        $area_nodes = [
            'LAGUNA.BAY',
            'LAGUNA.CABUYAO CITY',
            'LAGUNA.LOS BANOS',
        ];

        DB::transaction(function () use ($group_nodes, $area_nodes) {
            $contact = Contact::create(['mobile' => '+639954705290', 'handle' => 'HQ 1']);
            Contact::create(['mobile' => '+639202371976', 'handle' => 'HQ 2'], $contact);
            Contact::create(['mobile' => '+639565711304', 'handle' => 'HQ 3'], $contact);

            $category = Category::create(['name' => 'Governor']);
            Issue::make(['code' => 'RAMIL', 'name' => 'Ramil Hernandez'])->category()->associate($category)->save();
            Issue::make(['code' => 'ER', 'name' => 'ER Ejercito'])->category()->associate($category)->save();

            $category = Category::create(['name' => 'Representative']);
            Issue::make(['code' => 'BANJO', 'name' => 'Banjo Caringal'])->category()->associate($category)->save();
            Issue::make(['code' => 'GENUINO', 'name' => 'Efraim Genuino'])->category()->associate($category)->save();
            Issue::make(['code' => 'HEMEDEZ', 'name' => 'Isidro Hemedez Jr.'])->category()->associate($category)->save();
            Issue::make(['code' => 'RUTH', 'name' => 'Ruth Hernandez'])->category()->associate($category)->save();
            Issue::make(['code' => 'TIRSO', 'name' => 'Tirso Lavina'])->category()->associate($category)->save();
            Issue::make(['code' => 'REVILLA', 'name' => 'Rosauro Revilla'])->category()->associate($category)->save();

            $category = Category::create(['name' => 'System']);
            Issue::make(['code' => 'TOTAL', 'name' => 'Total Voters'])->category()->associate($category)->save();


            foreach ($group_nodes as $group_node) {
                Group::build($group_node);
            }
            foreach ($area_nodes as $area_node) {
                Area::build($area_node);
            }
        });

        Excel::import(new VolunteersImport, database_path($this->spreadsheet));
    }
}
