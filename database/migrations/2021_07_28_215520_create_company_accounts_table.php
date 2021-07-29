<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_user_id');
            $table->unsignedBigInteger('account_id');
            $table->string('cnpj', 18)->unique();
            $table->string('trading_name');
            $table->string('corporate_name');
            $table->timestamps();

            $table->foreign('owner_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_accounts');
    }
}
