<?Php
namespace datagutten\Inducks;
use datagutten\tools\PDOConnectHelper;
use WpOrg\Requests;

class Inducks
{    public Requests\Session $session;

    public function __construct($scrooge_url)
    {
        $this->session = new Requests\Session($scrooge_url);
    }

    public function get($url, $headers=[], $options=[])
    {
        $response = $this->session->get($url, $headers, $options);
        $response->throw_for_status();
        return $response->decode_body();
    }

    /**
     * Parse issue codes like "no/DP  434"
     * Sample: list($country, $series, $number) = self::parse_issue_code($code); 
     */
    public static function parse_issue_code(string $code): array
    {
        preg_match('#(\w+)/(\w+)\s*([0-9]+)#', $code, $matches);
        array_shift($matches);
        return $matches;
    }

    public function issue(string $code): array
    {
        list($country, $series, $number) = self::parse_issue_code($code);
        print_r([$country, $series, $number]);
        return $this->get(sprintf('series/%s/%s/issues/%s', $country, $series, $number));
    }
}