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
		Schema::create('orders', function (Blueprint $table) {
			$table->id();
			
			$table->unsignedBigInteger('user_id')->default(0)->comment('users table primary id');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->unsignedBigInteger('product_id')->default(0)->comment('products table primary id');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			
			$table->integer('quantity');
			$table->decimal('total_price', 10, 2);
			$table->string('status')->default('pending')->comment('Default Pending, Shipped, Delivered');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('orders');
	}
};
