<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("zaznamy", function (Blueprint $table) {
            $table->id();
            $table->string("jmeno");
            $table->string("prijmeni");
            $table->date("datum")->nullable();
        });

    }

    public function down(): void {
        Schema::dropIfExists("zaznamy");
    }
};
