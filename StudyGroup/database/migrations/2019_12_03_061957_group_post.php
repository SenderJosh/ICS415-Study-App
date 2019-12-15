<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GroupPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GroupPostTbl', function (Blueprint $table) {
            $table->bigIncrements('GroupPostID');
            $table->bigInteger('GroupOwnerID');
			$table->string('GroupName', 75);
			$table->string('ClassName', 75);
			$table->longText('Topics');
			$table->longText('GroupDescription');
			//Gross, but works
			$table->boolean('Monday');
			$table->boolean('Tuesday');
			$table->boolean('Wednesday');
			$table->boolean('Thursday');
			$table->boolean('Friday');
			$table->boolean('Saturday');
			$table->boolean('Sunday');
			$table->boolean('Deleted')->default(0);
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
        Schema::dropIfExists('GroupPostTbl');
    }
}
