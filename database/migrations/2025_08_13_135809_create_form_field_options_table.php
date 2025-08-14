<?php

use App\Models\FormField;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('form_field_options', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FormField::class);
            $table->string('option');
            $table->string('label');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_field_options');
    }
};
