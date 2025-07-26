<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Only add channel_id and a new composite index.
     * We do NOT drop anything, so the FK-not-found error disappears.
     */
    public function up(): void
    {
        Schema::table('product_price_indices', function (Blueprint $table) {

            /* add the new column only if it’s missing */
            if (! Schema::hasColumn('product_price_indices', 'channel_id')) {
                $table->unsignedInteger('channel_id')
                      ->default(1)
                      ->after('customer_group_id');
            }

            /* create the composite unique index if it isn’t there */
            $table->unique(
                ['product_id', 'customer_group_id', 'channel_id'],
                'price_indices_product_id_customer_group_id_channel_id_unique'
            );

            /* only the NEW FK for channel_id (name won’t collide) */
            $table->foreign('channel_id', 'ppi_channel_id_foreign')
                  ->references('id')->on('channels')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('product_price_indices', function (Blueprint $table) {

            /* drop FK & index if they exist, then column */
            try   { $table->dropForeign('ppi_channel_id_foreign'); } catch (\Throwable $e) {}
            try   { $table->dropUnique('price_indices_product_id_customer_group_id_channel_id_unique'); } catch (\Throwable $e) {}
            if (Schema::hasColumn('product_price_indices', 'channel_id')) {
                $table->dropColumn('channel_id');
            }
        });
    }
};

