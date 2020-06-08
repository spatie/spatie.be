<?php

return [

    /*
     * The mailer used by Mailcoach for password resets and summary emails.
     * Mailcoach will use the default Laravel mailer if this is not set.
     */
    'mailer' => null,

    /*
     * The default mailer used by Mailcoach for sending campaigns.
     */
    'campaign_mailer' => null,

    /*
     * The default mailer used by Mailcoach for confirmation and welcome mails.
     */
    'transactional_mailer' => null,

    /*
     * The date format used on all screens of the UI
     */
    'date_format' => 'Y-m-d H:i',

    /*
     * Replacers are classes that can make replacements in the html of a campaign.
     *
     * You can use a replacer to create placeholders.
     */
    'replacers' => [
        \Spatie\Mailcoach\Support\Replacers\WebviewReplacer::class,
        \Spatie\Mailcoach\Support\Replacers\SubscriberReplacer::class,
        \Spatie\Mailcoach\Support\Replacers\EmailListReplacer::class,
        \Spatie\Mailcoach\Support\Replacers\UnsubscribeUrlReplacer::class,
        \Spatie\Mailcoach\Support\Replacers\CampaignReplacer::class,
    ],

    /**
     * Here you can configure which template editor Mailcoach uses.
     * By default this is a text editor that highlights HTML.
     */
    'editor' => \Spatie\Mailcoach\Support\Editor\TextEditor::class,

    /*
     * Here you can specify which jobs should run on which queues.
     * Use an empty string to use the default queue.
     */
    'perform_on_queue' => [
        'calculate_statistics_job' => 'mailcoach',
        'send_campaign_job' => 'send-campaign',
        'send_mail_job' => 'send-mail',
        'send_test_mail_job' => 'mailcoach',
        'send_welcome_mail_job' => 'mailcoach',
        'process_feedback_job' => 'mailcoach-feedback',
        'import_subscribers_job' => 'mailcoach',
    ],

    /*
     * Here you can specify on which connection Mailcoach's jobs will be dispatched.
     * Leave empty to use the app default's env('QUEUE_CONNECTION')
     */
    'queue_connection' => '',

    /*
     * By default only 10 mails per second will be sent to avoid overwhelming your
     * e-mail sending service. To use this feature you must have Redis installed.
     */
    'throttling' => [
        'enabled' => true,
        'redis_connection_name' => 'default',
        'redis_key' => 'laravel-mailcoach',
        'allowed_number_of_jobs_in_timespan' => 10,
        'timespan_in_seconds' => 1,
        'release_in_seconds' => 5,
    ],

      /*
       * You can customize some of the behavior of this package by using our own custom action.
       * Your custom action should always extend the one of the default ones.
       */
    'actions' => [
        /*
         * Actions concerning campaigns
         */
        'calculate_statistics' => \Spatie\Mailcoach\Actions\Campaigns\CalculateStatisticsAction::class,
        'prepare_email_html' => \Spatie\Mailcoach\Actions\Campaigns\PrepareEmailHtmlAction::class,
        'prepare_subject' => \Spatie\Mailcoach\Actions\Campaigns\PrepareSubjectAction::class,
        'prepare_webview_html' => \Spatie\Mailcoach\Actions\Campaigns\PrepareWebviewHtmlAction::class,
        'convert_html_to_text' => \Spatie\Mailcoach\Actions\Campaigns\ConvertHtmlToTextAction::class,
        'personalize_html' => \Spatie\Mailcoach\Actions\Campaigns\PersonalizeHtmlAction::class,
        'personalize_subject' => \Spatie\Mailcoach\Actions\Campaigns\PersonalizeSubjectAction::class,
        'retry_sending_failed_sends' => \Spatie\Mailcoach\Actions\Campaigns\RetrySendingFailedSendsAction::class,
        'send_campaign' => \Spatie\Mailcoach\Actions\Campaigns\SendCampaignAction::class,
        'send_mail' => \Spatie\Mailcoach\Actions\Campaigns\SendMailAction::class,
        'send_test_mail' => \Spatie\Mailcoach\Actions\Campaigns\SendTestMailAction::class,

        /*
         * Actions concerning subscribers
         */
        'confirm_subscriber' => \Spatie\Mailcoach\Actions\Subscribers\ConfirmSubscriberAction::class,
        'create_subscriber' => \Spatie\Mailcoach\Actions\Subscribers\CreateSubscriberAction::class,
        'import_subscribers' => \Spatie\Mailcoach\Actions\Subscribers\ImportSubscribersAction::class,
        'send_confirm_subscriber_mail' => \Spatie\Mailcoach\Actions\Subscribers\SendConfirmSubscriberMailAction::class,
        'send_welcome_mail' => \Spatie\Mailcoach\Actions\Subscribers\SendWelcomeMailAction::class,
        'update_subscriber' => \Spatie\Mailcoach\Actions\Subscribers\UpdateSubscriberAction::class,
    ],

    /*
     * Unauthorized users will get redirected to this route.
     */
    'redirect_unauthorized_users_to_route' => 'login',

    /*
     *  This configuration option defines the authentication guard that will
     *  be used to protect your the Mailcoach UI. This option should match one
     *  of the authentication guards defined in the "auth" config file.
     */
    'guard' => env('MAILCOACH_GUARD', null),

    /*
     *  These middleware will be assigned to every Mailcoach UI route, giving you the chance
     *  to add your own middleware to this stack or override any of the existing middleware.
     */
    'middleware' => [
        'web',
        Spatie\Mailcoach\Http\App\Middleware\Authenticate::class,
        Spatie\Mailcoach\Http\App\Middleware\Authorize::class,
        Spatie\Mailcoach\Http\App\Middleware\SetMailcoachDefaults::class,
    ],

    /*
     * This disk will be used to store files regarding importing subscribers. This must
     * be a disk that uses the `local` driver.
     */
    'import_subscribers_disk' => 'public',


    'models' => [

        /*
         * The model you want to use as a Campaign model. It needs to be or
         * extend the `Spatie\Mailcoach\Models\Campaign` model.
         */
        'campaign' => Spatie\Mailcoach\Models\Campaign::class,

        /*
         * The model you want to use as a EmailList model. It needs to be or
         * extend the `Spatie\Mailcoach\Models\EmailList` model.
         */
        'email_list' => Spatie\Mailcoach\Models\EmailList::class,

        /*
         * The model you want to use as a Subscriber model. It needs to be or
         * extend the `Spatie\Mailcoach\Models\Subscriber` model.
         */
        'subscriber' => Spatie\Mailcoach\Models\Subscriber::class,

        /*
         * The model you want to use as a Template model. It needs to be or
         * extend the `Spatie\Mailcoach\Models\Template` model.
         */
        'template' => Spatie\Mailcoach\Models\Template::class,

    ],
];
