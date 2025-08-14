<?php

namespace Database\Seeders;

use App\Models\FormFieldType;
use Illuminate\Database\Seeder;

class FormFieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        FormFieldType::factory()->create(
            [
                'type' => 'text',
                'label' => 'Text Field',
                'options_required' => false,
            ]
        );
        FormFieldType::factory()->create(
            [
                'type' => 'select',
                'label' => 'Drop Down',
                'options_required' => true,
            ]
        );
    }
}
