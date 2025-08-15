<?php

namespace App\Services;

use App\Models\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class FormService
{
    /**
     * Create a new form with fields
     *
     */
    public function createForm(array $formData, array $fieldsData): Form
    {
        DB::beginTransaction();

        try {
            $form = Form::create($formData);

            foreach ($fieldsData as $fieldData) {
                $field = $form->fields()->create(Arr::except($fieldData, 'options'));
                if (!empty($fieldData['options'])) {
                    $field->options()->createMany($fieldData['options']);
                }
            }
            DB::commit();
            return $form;
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            throw $e;
        }
    }
}
