<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Models\Form;
use App\Models\FormFieldType;
use Inertia\Inertia;
use App\Services\FormService;

class FormController extends Controller
{
    protected $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('form/list', [
            'forms' => Form::where('is_active', true)
                ->with('user')
                ->orderBy('id', 'desc')
                ->paginate(7),
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
        $formData = $request->safe()->only([
            'title',
            'background_color',
            'is_label_enabled',
            'is_active'
        ]);
        $formData['user_id'] = $request->user()->id;
        $fieldsData = $request->safe()->input('custom_form_fields', []);
        try {
            $this->formService->createForm($formData, $fieldsData);
            return to_route('form.list')->with('success', __('messages.form_creation_success'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('messages.form_creation_error'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {

        return Inertia::render('form/view', [
            'formDetails' => $form->load(['fields.type', 'fields.options']),
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
