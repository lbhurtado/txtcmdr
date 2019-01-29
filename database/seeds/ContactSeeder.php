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
    }
}
