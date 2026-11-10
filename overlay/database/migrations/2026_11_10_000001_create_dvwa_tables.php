<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dvwa_users', function (Blueprint $t) {
            $t->increments('user_id');
            $t->string('first_name', 50);
            $t->string('last_name', 50);
            $t->string('user', 50)->unique();
            $t->string('password', 64);
            $t->unsignedInteger('failed_login')->default(0);
            $t->timestamp('last_login')->nullable();
        });
        Schema::create('guestbook', function (Blueprint $t) {
            $t->increments('comment_id');
            $t->string('comment', 300);
            $t->string('name', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guestbook');
        Schema::dropIfExists('dvwa_users');
    }
};
