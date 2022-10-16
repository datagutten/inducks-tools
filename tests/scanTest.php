<?Php

use datagutten\Inducks\Scan;
use PHPUnit\Framework\TestCase;

class scansTest extends TestCase
{
    public function testIssueCover()
    {
        $scan = new Scan();
        $image = $scan->issue_cover('no/DP  522');
        $this->assertEquals('https://inducks.org/hr.php?image=https%3A%2F%2Foutducks.org%2Fwebusers%2Fwebusers%2F2022%2F09%2Fno_dp_0522a_001.jpg', $image);
    }

    public function testStoryScan()
    {
        $scan = new Scan();
        $image = $scan->story_scan('D 2021-144');
        $this->assertEquals('https://inducks.org/hr.php?image=https%3A%2F%2Foutducks.org%2Fwebusers%2Fwebusers%2F2022%2F09%2Fde_ltb_563p005_001.jpg', $image);
    }
}