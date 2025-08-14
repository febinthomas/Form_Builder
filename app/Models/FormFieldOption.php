<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormFieldOption extends Model
{
    //

    public function formField(): BelongsTo
    {
        return $this->belongsTo(FormField::class);
    }
}
