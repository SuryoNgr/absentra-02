<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateAbsensisTable extends Migration
    {
        public function up()
        {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('petugas_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['checkin', 'terlambat checkin', 'lupa checkout', 'tidak masuk']);
            $table->timestamp('checkin_at')->nullable();
            $table->timestamp('checkout_at')->nullable();
            $table->string('foto_checkin')->nullable();
            $table->timestamps();
        });

        }

        public function down()
        {
            Schema::dropIfExists('absensis');
        }
    }

