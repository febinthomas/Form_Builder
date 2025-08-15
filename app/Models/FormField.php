<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormField extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'label',
        'form_field_type_id',
    ];

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
        return $this->belongsTo(FormFieldType::class, 'form_field_type_id');
    }

    /**
     * Get the options that owns the Field.
     */
    public function options(): HasMany
    {
        return $this->hasMany(FormFieldOption::class);
    }
}
