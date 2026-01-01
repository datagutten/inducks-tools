<?Php

namespace datagutten\Inducks;

class Inducks
{
    public ApiHelper $api;

    public function __construct($api_url)
    {
        $this->api = new ApiHelper($api_url);
    }

    /**
     * Parse issue codes like "no/DP  434"
     * Sample: list($country, $series, $number) = self::parse_issue_code($code);
     */
    public static function parse_issue_code(string $code): array
    {
        preg_match('#(\w+)/([A-Z]+)\s*([\d\-]+)#', $code, $matches);
        array_shift($matches);
        return $matches;
    }

    public function issue(string $code): array
    {
        return $this->api->api_request_single('issue', issuecode: $code);
    }
}