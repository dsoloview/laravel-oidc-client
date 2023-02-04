<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('oidc_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oidc_id')->unique();
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('id_token')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('oidc_users');
    }
};
