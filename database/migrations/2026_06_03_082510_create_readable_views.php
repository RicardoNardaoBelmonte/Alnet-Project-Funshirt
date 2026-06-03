<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // View: tshirts with owner email (category is already stored as a name)
        DB::statement("
            CREATE VIEW vw_tshirts AS
            SELECT
                t.id,
                t.name,
                t.description,
                t.price,
                t.sales_count,
                CASE
                    WHEN t.customer_id IS NULL THEN 'Catalogue'
                    ELSE 'Personalized'
                END AS type,
                COALESCE(t.category, '—') AS category,
                COALESCE(u.email, '—') AS owner,
                t.image_url,
                t.created_at
            FROM tshirts t
            LEFT JOIN customers cu ON cu.id = t.customer_id
            LEFT JOIN users u ON u.id = cu.user_id
            WHERE t.deleted_at IS NULL
        ");

        // View: tshirt-color pivot with tshirt name (color is already stored as a name)
        DB::statement("
            CREATE VIEW vw_tshirt_colors AS
            SELECT
                tc.tshirt_id,
                t.name AS tshirt,
                tc.color,
                col.code AS hex
            FROM tshirt_color tc
            JOIN tshirts t ON t.id = tc.tshirt_id
            JOIN colors col ON col.name = tc.color
            WHERE t.deleted_at IS NULL
            ORDER BY t.name, tc.color
        ");
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_tshirts');
        DB::statement('DROP VIEW IF EXISTS vw_tshirt_colors');
    }
};
