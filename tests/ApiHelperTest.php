<?php


use datagutten\Inducks\ApiHelper;
use PHPUnit\Framework\TestCase;

class ApiHelperTest extends TestCase
{
    public function testApi_request_single()
    {
        $api = new ApiHelper(getenv('INDUCKS_API'));
        $story = $api->api_request_single('story', storycode: 'AR 102');
        $this->assertEquals('The Son of the Sun', $story['title']);
    }
}
