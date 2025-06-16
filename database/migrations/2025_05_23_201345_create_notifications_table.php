<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->unsignedBigInteger('product_id')->nullable(); // Remove foreign key constraint for now
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            // We'll add the foreign key later
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};