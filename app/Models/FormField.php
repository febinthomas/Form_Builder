<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormField extends Model
{
    /**
     * Get the Form that owns the field.
     */
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
    /**
     * Get the Form Field type.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(FormFieldType::class, 'type_id');
    }
}
