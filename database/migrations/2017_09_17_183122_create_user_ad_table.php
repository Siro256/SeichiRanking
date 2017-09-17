<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAdTable extends Migration
{
    /**
     * ユーザ主体の広告管理用テーブル
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ad', function (Blueprint $table) {
            $table->increments('id');                       // primary_key
            $table->tinyInteger('reply_type');              // 連絡先タイプ(Twitter=1/Discord=2)
            $table->string('contact_id');                   // 連絡先ID
            $table->string('img_path', '128');      // 画像ファイルパス
            $table->string('redirect_url')->nullable();     // 広告押下時の遷移先URL
            $table->dateTime('publication_start_date');     // 公開開始日
            $table->dateTime('publication_end_date');       // 公開終了日
            $table->boolean('avail_flg')->default(0);       // 有効フラグ (デフォルト無効)
            $table->boolean('delete_flg')->default(0);      // 削除フラグ
            $table->timestamps();                                    // created_atカラムとupdated_atを追加
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_ad');
    }
}
