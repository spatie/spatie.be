<?php

use App\Models\Enums\VideoDisplayEnum;
use App\Models\Video;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVideoFields extends Migration
{
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('display')->after('only_for_sponsors')->default(VideoDisplayEnum::LICENSE);
        });

        Video::each(function (Video $video): void {
            $video->update([
                'display' => $video->only_for_sponsors ? VideoDisplayEnum::SPONSORS : VideoDisplayEnum::FREE,
            ]);
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('only_for_sponsors');
        });
    }
}
