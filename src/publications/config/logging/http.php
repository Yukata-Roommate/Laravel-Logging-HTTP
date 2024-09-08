<?php

return [
    /*----------------------------------------*
     * Basic
     *----------------------------------------*/

    "enable" => env("YR_LOGGING_HTTP_ENABLE", false),

    /*----------------------------------------*
     * Logging
     *----------------------------------------*/

    "logging" => [
        "base_directory" => env("YR_LOGGING_HTTP_BASE_DIRECTORY", storage_path("logs")),
        "directory"      => env("YR_LOGGING_HTTP_DIRECTORY", "http"),
        "file"           => [
            "name_format" => env("YR_LOGGING_HTTP_FILE_NAME_FORMAT", "Y-m-d"),
            "extension"   => env("YR_LOGGING_HTTP_FILE_EXTENSION", "log"),
            "mode"        => env("YR_LOGGING_HTTP_FILE_MODE", 0666),
            "owner"       => env("YR_LOGGING_HTTP_FILE_OWNER", null),
            "group"       => env("YR_LOGGING_HTTP_FILE_GROUP", null),
        ],
    ],

    /*----------------------------------------*
     * Contents
     *----------------------------------------*/

    "contents" => [
        "memory_peak_usage" => env("YR_LOGGING_HTTP_MEMORY_PEAK_USAGE", false),

        "execution_time" => env("YR_LOGGING_HTTP_EXECUTION_TIME", false),

        "request_url"         => env("YR_LOGGING_HTTP_REQUEST_URL", false),
        "request_http_method" => env("YR_LOGGING_HTTP_REQUEST_HTTP_METHOD", false),
        "request_user_agent"  => env("YR_LOGGING_HTTP_REQUEST_USER_AGENT", false),
        "request_ip_address"  => env("YR_LOGGING_HTTP_REQUEST_IP_ADDRESS", false),
        "request_body"        => env("YR_LOGGING_HTTP_REQUEST_BODY", false),

        "response_status" => env("YR_LOGGING_HTTP_RESPONSE_STATUS", false),
    ],

    /*----------------------------------------*
     * Masking
     *----------------------------------------*/

    "masking" => [
        "text"       => env("YR_LOGGING_HTTP_MASKING_TEXT", "********"),
        "parameters" => [
            "password",
            "password_confirmation",
            "current_password",
            "new_password",
            "new_password_confirmation",
        ],
    ],
];
