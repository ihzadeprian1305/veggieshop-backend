<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateVegetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vegetables', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('price')->nullable();
            $table->double('rate')->nullable();
            $table->integer('minimum_purchase')->nullable();
            $table->string('purchase_in')->nullable();
            $table->string('types')->nullable();
            $table->text('picturePath')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vegetables');
    }
}
