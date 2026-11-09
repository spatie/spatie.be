<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            foreach ([
                'mailcoach_automation_action_subscriber',
                'mailcoach_automation_actions',
                'mailcoach_automation_mail_clicks',
                'mailcoach_automation_mail_links',
                'mailcoach_automation_mail_opens',
                'mailcoach_automation_mail_unsubscribes',
                'mailcoach_automation_mails',
                'mailcoach_automation_triggers',
                'mailcoach_automations',
                'mailcoach_campaign_clicks',
                'mailcoach_campaign_links',
                'mailcoach_campaign_opens',
                'mailcoach_campaign_unsubscribes',
                'mailcoach_campaigns',
                'mailcoach_email_list_allow_form_subscription_tags',
                'mailcoach_email_list_subscriber_tags',
                'mailcoach_email_lists',
                'mailcoach_negative_segment_tags',
                'mailcoach_positive_segment_tags',
                'mailcoach_segments',
                'mailcoach_send_feedback_items',
                'mailcoach_sends',
                'mailcoach_subscriber_imports',
                'mailcoach_subscribers',
                'mailcoach_tags',
                'mailcoach_templates',
                'mailcoach_transactional_mail_clicks',
                'mailcoach_transactional_mail_opens',
                'mailcoach_transactional_mail_templates',
                'mailcoach_transactional_mails',
            ] as $table) {
                Schema::dropIfExists($table);
            }
        });
    }
};
