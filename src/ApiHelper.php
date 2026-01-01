<?php

namespace datagutten\Inducks;

use RuntimeException;
use WpOrg\Requests;

class ApiHelper
{
    private Requests\Session $session;

    public function __construct(string $api_url)
    {
        $this->session = new Requests\Session($api_url);
    }

    public static function replace_slash(string $code): string
    {
        return preg_replace('#([a-z]+)/(.+)#', '$1-$2', $code);
    }

    public static function replace_dash(string $code): string
    {
        return preg_replace('#([a-z]+)-(.+)#', '$1/$2', $code);
    }

    public function api_request(string $model, string $key): array
    {
        $uri = sprintf('%s/%s', $model, self::replace_slash($key));
        $response = $this->session->get($uri);
        $response->throw_for_status();
        return $response->decode_body();
    }

    public function api_request_single(string $model, ...$kwargs): array
    {
        $query = http_build_query($kwargs);
        $response = $this->session->get(sprintf('%s?%s', $model, $query));
        $response->throw_for_status();
        $data = $response->decode_body();
        if ($data['count'] == 0)
            throw new RuntimeException(sprintf('No element found for query %s', $query));
        elseif ($data['count'] > 1)
            throw new RuntimeException(sprintf('More than 1 element found for query %s', $query));
        return $data['results'][0];
    }
}