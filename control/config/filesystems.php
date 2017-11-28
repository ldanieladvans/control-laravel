<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

        'sftp' => [
            'type' => 'Sftp',
            'host' => '13.58.170.3',
            'username' => 'bitnami',
            'password' => 'Advan$97120',
            'port' => 22,
            'timeout' => 10,
            'privateKey' => '-----BEGIN RSA PRIVATE KEY-----
    MIIEowIBAAKCAQEA0dVJuaaJGwW4WFEtcdHvfXj+pj0n/VfEDfN1FMhrRXsOG8UY
    IwiKojV/HJjLIxx8PGIkesTeHfdKTRc8eCL6yBYVXKEmC3i5GZoEX9KBXFb2JuT4
    6IA6Y+NkFooV/l0HODdTWhsf3bqfEbC8OUNH+IBJN/NyXrYPGcodyWPOTEWaCTpA
    5v2ETMd8qCHcPooWzylw6dfqlT4tt7ebz01xJMmYb6hOkVwaTxi13sd7jfr/6d6j
    u6y/qXYh23Xkx3fCr2q/LuXnV6zE4L+eTZOxsVbAhjFqW8IELxweBIrHbceBsldT
    NFeEC3WXYAy8bLgV52Rnt54+pUTdwmG4j0MScQIDAQABAoIBAFW9XFmytdVH2hKk
    YPhgOwa/GPaeiKeZZC/7Kf0rA8IpTROFzp4KEHPFfkIWIPMg4Zbe118e8E+4SzEC
    7J9+U5DMjUADTQNk+eV/LIhnAJrVodE0wIxoUPOd57jaBbChHKEY4kMwUC4O4o6c
    89xGJLNi4Agvvqz6oWL9VnyC/rnk/WNvexcarZk1gpd5ETmG0zLAO2Al5fADUK5u
    b3p7EDe3a00tI4QpaGMRVrR1UB/W550Y/UCkOjyp8Wt2yHMcmvmaGKTdm5hxhMms
    8Wl/44kEjY71hlW1KrOMPZ7oRsjjeryfvee7VMlbNugN8e9B5m58itZILDgecl+G
    Ums9RFECgYEA665KY91oUesK+fd6SKCzAm0/XuivHWrw2uzdtpwJYqVjc7GXAyQr
    GdxJWadHqTW6xGZ/+Y1qEjkSk/4jfWRsD8MAcpL7AFR+1R/9/C/c+tubH+/asqSE
    jw3ednT3fkYx/9aaQMlMRPQb/PTw89q8BdJlNp6x8FEb2DZG5l3W6wUCgYEA4+yD
    hw03u/KG6TfjyWTYNdYFz7ucF0hdbzm21zSjI/1yj7qwUtxywgTWZfquHSXtn11Q
    +M2u+KV90F4gtCInWrkz/PK8lMKQay1AmF7XXrHwwTgi6SC3ovPN0r2gIxEsaUKb
    Ml8tlH3DbUjKX3f5Y5oHwRP/7WPq+W0Ch8Pj3X0CgYEAgknZ6hdOQmsTqFh9i4T7
    MQ5ACDHODQ8/k2d6sibUsWoI7r5wY1YtVaCIFD37yblgRI79lHHu/5/5e0L1T66i
    ZpxAtRY4GFidvShwemfjW/LncOJiHnwApCzgnM/QukgIAA0dPU+LEFt61X57bfOw
    Ge/T8DwO1nGgWQi4bUXXOBkCgYBR81xnVq1PeqhfeqUAaK4EzWtRgddh17cgotPH
    FToDWsGyRCHZ6UGp2Stth3DLMjP6NQdELlBXPsm5/d4sZotX53d136FGq55Zqu+q
    2Y7+kWRLVO/YetcMVDURLPVDJo2dW0GKHwa4eW+m/6EkKnMVCPD4z0QaCu8Vt8hN
    IHXx0QKBgCoekexUPsz6N57c5ZIIHyheh8A/3HrCSoQqmqoSZl+6ikAzKBf9IcPU
    /Ncmln0L4fUwCoZI1gW5ozlX/wOlBxGlqgxw+LkklL4LdnDd6xylxFlUC5D9UjHO
    V/VmXR686Z5/VmghvS0ZJsv8f9AQbxZ0N9ikB0izKUKCpwe7qF+J
    -----END RSA PRIVATE KEY-----',
            'root' => '/opt/bitnami/apache2/htdocs/mabel/',
        ],

    ],

];
