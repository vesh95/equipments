<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE = 'equipment';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(self::TABLE, static function(Blueprint $table) {
            $table->id();
            $table->bigInteger('equipment_type_id')
                ->unsigned()
                ->nullable(false);
            $table->foreign('equipment_type_id')
                ->references('id')
                ->on('equipment_types');
            $table->string('serial_number')->unique()->nullable(false);
            $table->string('note')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop(self::TABLE);
    }
};
