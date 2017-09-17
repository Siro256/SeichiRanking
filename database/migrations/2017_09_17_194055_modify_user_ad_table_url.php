<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserAdTableUrl extends Migration
{
    /**
     * 遷移先URLの型を変更する
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_ad', function ($table) {
            $table->text('redirect_url')->change();
        });
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
