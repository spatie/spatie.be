<?php

use App\Models\License;
use App\Models\Purchasable;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UpdateLicensesAddSpatieMasterKey extends Migration
{
    public function up()
    {
        Schema::table('licenses', function (Blueprint $table) {
            $spatie = User::firstOrCreate(['email' => 'info@spatie.be'], [
                'name' => 'Spatie Technical',
                'password' => bcrypt(Str::random()),
                'is_admin' => true,
            ]);

            $purchasable = Purchasable::query()
                ->where('requires_license', true)
                ->first();

            if ($purchasable) {
                License::firstOrCreate([
                    'user_id' => $spatie->id,
                    'key' => config('spatie.master_license_key'),
                ], [
                    'satis_authentication_count' => 0,
                    'purchasable_id' => $purchasable->id,
                ]);
            }
        });
    }
}
