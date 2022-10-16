<?Php
namespace datagutten\Inducks;
use DOMDocument;
use DOMNodeList;
use DOMXPath;
use WpOrg\Requests;

class Scan
{
    public Requests\Session $session;
    function __construct()
    {
        $this->session = new Requests\Session('https://inducks.org/');
    }

    /**
     * HTTP GET request
     * @param string $url URL to GET
     * @return string Response body
     */
    public function get(string $url): string
    {
        $response = $this->session->get($url);
        $response->throw_for_status();
        return $response->body;
    }

    /**
     * Get a page and return a DOMXpath object for the page
     * @param string $url Page URL
     * @return DOMXPath
     * 
     */
    public function get_xpath(string $url): DOMXPath
    {
        $data = $this->get($url);
        $dom = new DOMDocument();
        @$dom->loadHTML($data);
        return new DOMXPath($dom);
    }

    /**
     * Get highlighted image
     */
    protected static function cover_url(DOMNodeList $cover)
    {
        //$cover = $xpath->query('//div[@class="issueImageHighlight"]/div/figure/img/@src');
        $url = $cover->item(0)->textContent;
        $url = substr($url, 0, strpos($url, '&'));
        return 'https://inducks.org/'.$url;
    }

    public function issue_cover($issuecode)
    {
        $xpath = $this->get_xpath('issue.php?c='.$issuecode);
        $cover = $xpath->query('//div[@class="issueImageHighlight"]/div/figure/img/@src');
        return self::cover_url($cover);
    }

    public function story_scan($storycode)
    {
        $xpath = $this->get_xpath('story.php?c='.$storycode);
        $cover = $xpath->query('//div[@class="highlightScan"]/div/figure/img/@src');
        return self::cover_url($cover);
    }
}