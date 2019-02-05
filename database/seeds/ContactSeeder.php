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
        tap(Contact::create(['mobile' => '+639173011987', 'handle' => 'Lester Hurtado']), function ($contact) {
        	$contact->token = 'HjvtzaRUyDDUANLR3bvcpqLeWQG_WpXsq7PJaxArctI';
        })->save();
        tap(Contact::create(['mobile' => '+639166033598', 'handle' => 'Chris Suguitan']), function ($contact) {
            $contact->token = 'wYe8ubCzFWZWKEZOXQ6rozwV9h8h_Hj47v3D4fOezKg';
        })->save();
        tap(Contact::create(['mobile' => '+639177210752', 'handle' => 'Francesca Hurtado']), function ($contact) {
            $contact->token = 'VE7tjY5QRGViysms339jNv_Dkq9tbOLQPX5GbSz0zOc';
        })->save();
        tap(Contact::create(['mobile' => '+639399236237', 'handle' => 'Sofia Hurtado']), function ($contact) {
            $contact->token = 'bVVknsRfb0Rw2HF_a4SVMZ-zBuJb5AI2U0K-aQPXKMs';
        })->save();
        tap(Contact::create(['mobile' => '+639175180722', 'handle' => 'Apple Hurtado']), function ($contact) {
            $contact->token = 'jvZpwhjqaqvr3oE_ar4m7se6cg2LfmEHjuHLTOaCqls';
        })->save();
    }
}
