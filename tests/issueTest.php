<?Php
//no/DP%20%20502
use datagutten\Inducks;
use PHPUnit\Framework\TestCase;

class issueTest extends TestCase
{
    public function testIssueCode()
    {
        $inducks = new Inducks\Inducks(getenv('INDUCKS_API'));
        $issue = $inducks->issue('no/DP  433');
        $this->assertEquals('Gavepakke', $issue['title']);
    }
    
}