<?php

use Illuminate\Database\Seeder;
use App\Missive\Domain\Models\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lester = tap(Contact::create(['mobile' => '+639173011987', 'handle' => 'Lester Hurtado']), function ($contact) {
        	$contact->token = 'HjvtzaRUyDDUANLR3bvcpqLeWQG_WpXsq7PJaxArctI';
            $contact->save();
        });
        $levi = tap(Contact::create(['mobile' => '+639178915975', 'handle' => 'Levi Baligod']), function ($contact) {
            $contact->token = 'sGqcYEYY2Y3aWrYEhaMgSMlOQKSraa2hFMLuRVTluwY';
            $contact->save();
        });
        $obbie = tap(Contact::create(['mobile' => '+639166033598', 'handle' => 'Chris Suguitan']), function ($contact) {
            $contact->token = 'wYe8ubCzFWZWKEZOXQ6rozwV9h8h_Hj47v3D4fOezKg';
            $contact->save();
        });
        $francesca = tap(Contact::create(['mobile' => '+639177210752', 'handle' => 'Francesca Hurtado'], $lester), function ($contact) {
            $contact->token = 'VE7tjY5QRGViysms339jNv_Dkq9tbOLQPX5GbSz0zOc';
            $contact->save();
        });
        $sofia = tap(Contact::create(['mobile' => '+639399236237', 'handle' => 'Sofia Hurtado'], $lester), function ($contact) {
            $contact->token = 'bVVknsRfb0Rw2HF_a4SVMZ-zBuJb5AI2U0K-aQPXKMs';
            $contact->save();
        });
        $apple = tap(Contact::create(['mobile' => '+639175180722', 'handle' => 'Apple Hurtado'], $lester), function ($contact) {
            $contact->token = 'jvZpwhjqaqvr3oE_ar4m7se6cg2LfmEHjuHLTOaCqls';
            $contact->save();
        })->save();

        $joan = tap(Contact::create(['mobile' => '+639175793359', 'handle' => 'Joan Cruz']), function ($contact) {
            $contact->token = 'JBc5yuMukLuUt20JPSgrKK_Ha28VOz1zD1EGOmsknPY';
            $contact->save();
        });
        $smart = tap(Contact::create(['mobile' => '+639081877788', 'handle' => 'Smart Subscriber']), function ($contact) {
//            $contact->token = 'JBc5yuMukLuUt20JPSgrKK_Ha28VOz1zD1EGOmsknPY';
//            $contact->save();
        });

        $obbie->appendToNode($lester)->save();
        $levi->appendToNode($obbie)->save();
        $joan->appendToNode($obbie)->save();
    }
}
