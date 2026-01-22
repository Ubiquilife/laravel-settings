<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $table;
    protected string $keyColumn;
    protected string $valueColumn;

    public function __construct()
    {
        $this->table = Config::get('settings.table', Config::get('anlutro/l4-settings::table', 'settings'));
        $this->keyColumn = Config::get('settings.keyColumn', Config::get('anlutro/l4-settings::keyColumn', 'key'));
        $this->valueColumn = Config::get('settings.valueColumn', Config::get('anlutro/l4-settings::valueColumn', 'value'));
    }

    public function up(): void
    {
        if (!Schema::hasTable($this->table)) {
            return;
        }

        Schema::table($this->table, function (Blueprint $table) {
            if (!Schema::hasColumn($this->table, 'settable_id')) {
                $table->uuid('settable_id')->nullable()->after($this->keyColumn === 'id' ? 'id' : $this->keyColumn);
            }
            if (!Schema::hasColumn($this->table, 'settable_type')) {
                $table->string('settable_type')->nullable()->after('settable_id');
            }
            if (!Schema::hasColumn($this->table, 'id')) {
                $table->uuid('id')->primary()->first();
            }
            if (!Schema::hasColumn($this->table, 'created_at')) {
                $table->timestamps();
            }
            $table->index(['settable_type', 'settable_id'], $this->table.'_settable_index');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable($this->table)) {
            return;
        }

        Schema::table($this->table, function (Blueprint $table) {
            if (Schema::hasColumn($this->table, 'settable_type')) {
                $table->dropIndex($this->table.'_settable_index');
                $table->dropColumn(['settable_type', 'settable_id']);
            }
        });
    }
};
