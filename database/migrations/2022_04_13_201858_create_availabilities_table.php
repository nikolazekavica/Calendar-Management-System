<?php

use App\Helpers\Constants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('availability_status',Constants::ENUM_AVAILABILITY_STATUS);
            $table->string('timezone');
            $table->string('description')->nullable();
            $table->boolean('is_recurrences')->default(0);
            $table->date('start_date_recurrences')->nullable();
            $table->date('end_date_recurrences')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
        Schema::table('availabilities', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('availabilities');
        Schema::enableForeignKeyConstraints();
    }
};
