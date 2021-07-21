<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
            $table->index('user_type');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->index('title');
            $table->index('user_id');
        });

        Schema::table('assigned_users', function (Blueprint $table) {
            $table->index('blogger_id');
            $table->index('supervisor_id');
        });

        DB::statement("ALTER TABLE `blogs` ADD FULLTEXT(`description`);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
