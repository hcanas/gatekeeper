<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_permission_role', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_role_id');
            $table->unsignedBigInteger('office_id');

            $table->unique(['permission_role_id', 'office_id']);
            $table->foreign('permission_role_id')->references('id')->on('permission_role');
            $table->foreign('office_id')->references('id')->on('offices');

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('office_permission_role');
    }
}
