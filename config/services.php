<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | TernakPark Custom Services
    |--------------------------------------------------------------------------
    |
    | Configuration untuk integrasi dengan backend API dan external services
    |
    */

    'backend' => [
        // Base URL untuk backend Laravel API
        'base_url' => env('BACKEND_API_URL', 'http://localhost:8000'),

        // Timeout untuk request ke backend (dalam detik)
        'timeout' => env('BACKEND_API_TIMEOUT', 30),

        // Retry configuration
        'retry' => [
            'times' => env('BACKEND_API_RETRY_TIMES', 3),
            'sleep' => env('BACKEND_API_RETRY_SLEEP', 100), // dalam milidetik
        ],

        // API Version
        'version' => env('BACKEND_API_VERSION', 'v1'),

        // Endpoints khusus
        'endpoints' => [
            'livestocks' => '/api/livestocks',
            'pens' => '/api/pens',
            'farms' => '/api/farms',
            'feeds' => '/api/feeds',
            'predictions' => '/api/predictions',
            'weight_records' => '/api/weight-records',
        ],
    ],

    'ml_service' => [
        // Machine Learning API configuration
        'base_url' => env('ML_API_URL', 'http://localhost:5000'),
        'timeout' => env('ML_API_TIMEOUT', 60),
        'api_key' => env('ML_API_KEY'),

        // Endpoints
        'endpoints' => [
            'predict' => '/api/predict',
            'train' => '/api/train',
            'health' => '/api/health',
        ],
    ],

    'prediction_service' => [
        // Prediction model configuration
        'model_version' => env('PREDICTION_MODEL_VERSION', 'v1.0'),
        'confidence_threshold' => env('PREDICTION_CONFIDENCE_THRESHOLD', 0.7),
        'batch_size' => env('PREDICTION_BATCH_SIZE', 10),

        // Feature configuration
        'features' => [
            'weight_gain' => [
                'required' => ['current_weight', 'age_days', 'breed_type', 'feed_composition'],
                'optional' => ['health_status', 'pen_category', 'temperature', 'humidity'],
            ],
        ],
    ],

    'livestock_monitoring' => [
        // Monitoring intervals (in days)
        'weight_check_interval' => env('WEIGHT_CHECK_INTERVAL', 7),
        'health_check_interval' => env('HEALTH_CHECK_INTERVAL', 30),
        'feed_monitoring_interval' => env('FEED_MONITORING_INTERVAL', 1),

        // Alert thresholds
        'weight_gain_threshold' => env('WEIGHT_GAIN_THRESHOLD', 0.1), // kg/hari
        'health_risk_threshold' => env('HEALTH_RISK_THRESHOLD', 0.3),
    ],

    'notification' => [
        // Notification channels
        'channels' => ['database', 'mail'], // database, mail, slack, sms

        // Events to notify
        'events' => [
            'low_feed_stock' => true,
            'health_risk_detected' => true,
            'weight_gain_abnormal' => true,
            'prediction_ready' => true,
        ],
    ],

];
