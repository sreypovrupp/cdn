<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = "create view view_product as select
                p.id,
                p.name,
                p.price,
                p.photo,
                p.dsc,
                p.category,
                concat(c.name, '-', c.name_kh) as category_name
                from category c INNER JOIN product p on p.category = c.id";

        /*Schema::create('view_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });*/
        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("drop view if exists view_product;");
    }
}
