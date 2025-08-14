<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormFieldType>
 */
class FormFieldTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $word = $this->faker->word();

        return [
            'type' => $word,
            'label' => ucwords($word),
            'options_required' => false,
        ];
    }
}
