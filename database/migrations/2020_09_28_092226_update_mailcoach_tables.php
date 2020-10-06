<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Mailcoach\Models\Campaign;

class UpdateMailcoachTables extends Migration
{
    public function up()
    {
        Schema::table('mailcoach_campaigns', function (Blueprint $table) {
            $table->string('reply_to_email')->nullable();
            $table->string('reply_to_name')->nullable();
            $table->string('send_batch_id')->nullable();
            $table->timestamp('all_jobs_added_to_batch_at')->nullable();
        });

        Schema::table('mailcoach_subscribers', function (Blueprint $table) {
            $table->uuid('imported_via_import_uuid')->nullable();
        });

        Schema::table('mailcoach_subscriber_imports', function (Blueprint $table) {
            $table->boolean('subscribe_unsubscribed')->default(false);
            $table->boolean('unsubscribe_others')->default(false);
        });

        Schema::table('mailcoach_email_lists', function (Blueprint $table) {
            $table->string('default_reply_to_email')->nullable();
            $table->string('default_reply_to_name')->nullable();
            $table->text('allowed_form_extra_attributes')->nullable();
        });

        Schema::table('mailcoach_sends', function (Blueprint $table) {
            $table->index('uuid');
            $table->index(['campaign_id', 'subscriber_id']);
        });

        if (! Schema::hasTable('webhook_calls')) {
            Schema::create('webhook_calls', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('name');
                $table->json('payload')->nullable();
                $table->text('exception')->nullable();

                $table->timestamps();
            });
        }

        Schema::table('webhook_calls', function (Blueprint $table) {
            $table->string('external_id')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->index('external_id');
        });

        Campaign::each(function (Campaign $campaign): void {
            $campaign->update([
                'open_rate' => $campaign->open_rate * 100,
                'click_rate' => $campaign->click_rate * 100,
                'bounce_rate' => $campaign->bounce_rate * 100,
                'unsubscribe_rate' => $campaign->unsubscribe_rate * 100,
            ]);
        });
    }
}
