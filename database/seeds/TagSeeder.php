<?php

use Illuminate\Database\Seeder;
use App\Campaign\Domain\Models\Area;
use App\Campaign\Domain\Models\Group;
use App\Missive\Domain\Models\Contact;
use App\Campaign\Domain\Models\Campaign;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contact = Contact::where(['mobile' => '+639954705290'])->first();

        optional($contact->addTag('CAB'), function ($tag) {
            optional(Area::where('name', 'CABUYAO CITY')->first(), function ($area) use ($tag) {
                $tag->setArea($area, true);
            });
            optional(Group::where('name', 'WATCHER')->first(), function ($group) use ($tag) {
                $tag->setGroup($group, true);
            });
            optional(Campaign::where('name', 'default')->first(), function ($campaign) use ($tag) {
                $tag->setCampaign($campaign, true);
            });
        });

        optional($contact->addTag('BAY'), function ($tag) {
            optional(Area::where('name', 'Bay')->first(), function ($area) use ($tag) {
                $tag->setArea($area, true);
            });
            optional(Group::where('name', 'WATCHER')->first(), function ($group) use ($tag) {
                $tag->setGroup($group, true);
            });
            optional(Campaign::where('name', 'default')->first(), function ($campaign) use ($tag) {
                $tag->setCampaign($campaign, true);
            });
        });

        optional($contact->addTag('LB'), function ($tag) {
            optional(Area::where('name', 'LOS BANOS')->first(), function ($area) use ($tag) {
                $tag->setArea($area, true);
            });
            optional(Group::where('name', 'WATCHER')->first(), function ($group) use ($tag) {
                $tag->setGroup($group, true);
            });
            optional(Campaign::where('name', 'default')->first(), function ($campaign) use ($tag) {
                $tag->setCampaign($campaign, true);
            });
        });
    }
}
