<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 隱私
        Schema::create('private', function (Blueprint $table) {
            $table->id()->unique();;
            $table->string('account')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        // 會員
        Schema::create('member', function (Blueprint $table) {
            $table->id()->unique();;
            $table->unsignedBigInteger('private_id') -> unique(); // 外鍵
            $table->string('name');
            $table->string('phone') ->unique();;
            $table->date('birth');
            // 安全問題
            $table->integer('safe_ques1');
            $table->integer('safe_ques2');
            $table->longText('safe_ans1');
            $table->longText('safe_ans2');
            $table->timestamps();

            $table->foreign('private_id')->references('id')->on('private')->onDelete('cascade');
        });
        // 商店
        Schema::create('store', function (Blueprint $table) {
            $table->id() ->unique();;
            $table->unsignedBigInteger('private_id') -> unique(); // 外鍵

            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('owner_name');
            $table->timestamps();

            $table->foreign('private_id')->references('id')->on('private')->onDelete('cascade');
        });

        Schema::create('store_info', function (Blueprint $table) {
            $table->id() ->unique();;
            $table->unsignedBigInteger('store_id') -> unique(); // 外鍵
            $table->string('name');
            $table->string('address');
            $table->longText('intro');
            $table->longText('tag');
            $table->string('picUrl');

            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('store')->onDelete('cascade');
        });
        // 產品類別
        Schema::create('product_cate', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        // 產品
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_cate_id');
            $table->unsignedBigInteger('store_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->text("picUrl");
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('store')->onDelete('cascade');
            $table->foreign('product_cate_id')->references('id')->on('product_cate')->onDelete('cascade');
        });

        // 評論
        Schema::create('comment', function (Blueprint $table) {
            $table->id()->unique();;
            $table->unsignedBigInteger('store_id');
            $table->integer('star');
            $table->string('comment');

            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('store')->onDelete('cascade');
        });
        // 瀏覽
        Schema::create('look', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->unsignedBigInteger('store_id');
            $table->integer('count');
            $table->foreign('store_id')->references('id')->on('store')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private');
        Schema::dropIfExists('member');
        Schema::dropIfExists('store');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_cate');
        Schema::dropIfExists('collect');
        Schema::dropIfExists('look');
        Schema::dropIfExists('comment');

    }
};
