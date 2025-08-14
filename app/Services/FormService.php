<?php

namespace App\Services;

use App\Models\Form;
use Illuminate\Support\Facades\DB;

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

            if (!empty($fieldsData)) {
                $form->fields()->createMany($fieldsData);
                // Todo: Save Field Options if needed
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
