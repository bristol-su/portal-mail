<?php

namespace BristolSU\Database\Mail\Factories;

use BristolSU\ControlDB\Models\User;
use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Mail\Models\EmailAddressUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailAddressUserFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmailAddressUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'email_address_id' => fn() => EmailAddress::factory()->create()->id,
            'user_id' => fn() => User::factory()->create()->id
        ];
    }

}
