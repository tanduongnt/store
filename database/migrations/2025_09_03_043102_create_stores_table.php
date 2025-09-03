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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->double('unit')->default(0);
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('address');
            $table->string('tax')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->longText('notes')->nullable();
            $table->json('attachments');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained();
            $table->string('contract_number')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('note')->nullable();
            $table->json('files')->nullable();
            $table->timestamps();
        });

        Schema::create('contract_product', function (Blueprint $table) {
            $table->foreignId('contract_id')->nullable()->constrained();
            $table->foreignId('product_id')->nullable()->constrained();
            $table->double('price')->default(0);
            $table->timestamps();
        });

        Schema::create('purchases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('supplier_id')->nullable()->constrained();
            $table->timestamp('date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('code')->nullable();
            $table->longText('description')->nullable();
            $table->double('amount')->default(0);
            $table->double('vat_amount')->default(0);
            $table->double('total_amount')->default(0);

            $table->string('receiver')->nullable();
            $table->string('position')->nullable();

            $table->json('attachments')->nullable();

            $table->boolean('provided')->default(false);
            $table->timestamps();
        });

        Schema::create('product_purchase', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('purchase_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->double('quantity')->default(0);
            $table->double('price')->default(0);
            $table->double('total_cost')->default(0);
            $table->double('vat')->default(0);
            $table->double('amount')->default(0);
            $table->timestamps();

            $table->unique(['product_id', 'purchase_id']);
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('date');
            $table->string('code');
            $table->longText('description')->nullable();
            $table->json('files')->nullable();
            $table->json('images')->nullable();

            $table->string('receiver')->nullable();
            $table->string('position')->nullable();

            $table->boolean('import');
            $table->timestamps();
        });

        Schema::create('product_transaction', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained();
            $table->foreignUuid('transaction_id')->constrained();
            $table->double('quantity')->default(0);
            $table->timestamps();

            $table->primary(['product_id', 'transaction_id']);
        });

        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name');
            $table->double('price')->default(0);
            $table->double('discount_price')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('product_recipe', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained();
            $table->foreignId('recipe_id')->constrained();
            $table->double('quantity')->default(0);
            $table->timestamps();

            $table->primary(['recipe_id', 'product_id']);
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status');
            $table->double('total')->default(0);
            $table->string('payment_status');
            $table->string('payment_method')->nullable();
            $table->foreignUuid('user_id')->constrained();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('order_id')->constrained();
            $table->foreignUuid('recipe_id')->constrained();
            $table->double('quantity')->default(0);
            $table->double('price')->default(0);
            $table->double('total')->default(0);
            $table->timestamps();
        });
    }
};
