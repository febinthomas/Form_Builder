<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Form;
use App\Models\FormFieldType;
use App\Models\FormField;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class FormControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function index_displays_active_forms()
    {
        $user = User::factory()->create();

        // Create active and inactive forms
        $activeForm = Form::factory()->create(['is_active' => true, 'user_id' => $user->id]);
        $inactiveForm = Form::factory()->create(['is_active' => false, 'user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('form.list'));

        $response->assertStatus(200);
        $response->assertInertia(
            fn ($page) =>
            $page->component('form/list')
                ->has('forms.data', 1) // Only the active form should be returned
        );
    }

    #[Test]
    public function create_displays_form_field_types()
    {
        $user = User::factory()->create();
        $activeType = FormFieldType::factory()->create(['is_active' => true]);
        $inactiveType = FormFieldType::factory()->create(['is_active' => false]);

        $response = $this->actingAs($user)->get(route('form.create'));

        $response->assertStatus(200);
        $response->assertInertia(
            fn ($page) =>
            $page->component('form/create')
                ->has('fieldTypes', 1) // Only active field types
        );
    }

    #[Test]
    public function store_form_successfully()
    {
        $user = User::factory()->create();
        $fieldType = FormFieldType::factory()->create();

        $payload = [
            'title' => 'Test Form',
            'background_color' => '#FF5733',
            'is_label_enabled' => true,
            'is_active' => true,
            'custom_form_fields' => [
                [
                    'label' => 'Field 1',
                    'form_field_type_id' => $fieldType->id,
                    'options' => [
                        ['option' => 'Option 1', 'label' => 'Option Label 1'],
                    ],
                ],
            ],
        ];

        $response = $this->actingAs($user)
            ->post(route('form.store'), $payload);

        $response->assertRedirect(route('form.list'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('forms', ['title' => 'Test Form', 'user_id' => $user->id]);
    }

    #[Test]
    public function store_form_validation_fails()
    {
        $user = User::factory()->create();

        $payload = [
            'title' => '',
            'background_color' => 'invalidcolor',
            'is_label_enabled' => 'not_boolean',
            'is_active' => null,
            'custom_form_fields' => [],
        ];

        $response = $this->actingAs($user)
            ->post(route('form.store'), $payload);

        $response->assertSessionHasErrors([
            'title',
            'background_color',
            'is_label_enabled',
            'is_active',
            'custom_form_fields',
        ]);
    }

    #[Test]
    public function show_displays_form_with_fields_and_options()
    {
        $user = User::factory()->create();
        $form = Form::factory()->create(['user_id' => $user->id]);
        $fieldType = FormFieldType::factory()->create();
        $field = FormField::factory()->create([
            'form_id' => $form->id,
            'form_field_type_id' => $fieldType->id
        ]);

        $response = $this->actingAs($user)->get(route('form.show', $form));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
        $page->component('form/view')
            ->has('formDetails.fields', 1));
    }
}
