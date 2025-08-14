<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Models\Form;
use App\Models\FormFieldType;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('form/list', [
            'forms' => Form::where('is_active', true)
                ->with('user')
                ->orderBy('id', 'desc')
                ->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('form/create', [
            'fieldTypes' => FormFieldType::where('is_active', true)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFormRequest $request)
    {
        $validatedFormData = $request->safe()->only([
            'title',
            'background_color',
            'is_label_enabled',
        ]);
        $validatedFormData['is_active'] = 1;
        $validatedFormData['user_id'] = $request->user()->id;
        $validatedFieldData = $request->safe()->only('custom_form_fields');
        DB::beginTransaction();
        try {
            $form = Form::create($validatedFormData);
            foreach ($validatedFieldData as $fieldData) {
                $fields = $form->fields()->createMany($fieldData);
                // Todo: Save Field Options
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            throw $e;
        }

        return to_route('form.list');
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {

        return Inertia::render('form/view', [
            'formDetails' => $form->load(['fields.type', 'fields.options'])->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFormRequest $request, Form $form)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        //
    }
}
