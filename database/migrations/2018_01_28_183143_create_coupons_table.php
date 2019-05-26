<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class CreateCouponsTable extends Migration { public function up() { Schema::create('coupons', function (Blueprint $sp185401) { $sp185401->increments('id'); $sp185401->integer('user_id')->index(); $sp185401->integer('category_id')->default(-1); $sp185401->integer('product_id')->default(-1); $sp185401->integer('type')->default(\App\Coupon::TYPE_REPEAT); $sp185401->integer('status')->default(\App\Coupon::STATUS_NORMAL); $sp185401->string('coupon', 100)->index(); $sp185401->integer('discount_type'); $sp185401->integer('discount_val'); $sp185401->integer('count_used')->default(0); $sp185401->integer('count_all')->default(1); $sp185401->string('remark')->nullable(); $sp185401->dateTime('expire_at')->nullable(); $sp185401->timestamps(); }); } public function down() { Schema::dropIfExists('coupons'); } }