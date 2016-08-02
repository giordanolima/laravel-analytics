<?php

namespace Spatie\Analytics;

use Google_Client;
use Google_Service_Analytics;
use Illuminate\Contracts\Cache\Repository;

class AnalyticsClientFactory
{
    public static function createForConfig($analyticsConfig)
    {
        $authenticatedClient = self::createAuthenticatedGoogleClient($analyticsConfig);

        $googleService = new Google_Service_Analytics($authenticatedClient);

        return self::createAnalyticsClient($analyticsConfig, $googleService);
    }

    public static function createAuthenticatedGoogleClient($config)
    {
        $client = new Google_Client();

        $arr = storage_path('app/laravel-google-analytics/google-cache/');
        if(is_array($config) && array_key_exists("cache_location", $config))
            $arr = $config['cache_location'];
        $client->setClassConfig(
            'Google_Cache_File', 
            'directory', 
            $arr
        );

        $credentials = $client->loadServiceAccountJson(
            $config['service_account_credentials_json'],
            'https://www.googleapis.com/auth/analytics.readonly'
        );

        $client->setAssertionCredentials($credentials);

        return $client;
    }

    protected static function createAnalyticsClient($analyticsConfig, $googleService)
    {
        $client = new AnalyticsClient($googleService, app(Repository::class));

        $client->setCacheLifeTimeInMinutes($analyticsConfig['cache_lifetime_in_minutes']);

        return $client;
    }
}
