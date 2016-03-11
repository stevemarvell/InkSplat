<?php

use App\Dribble;

class WebTest extends PHPUnit_Framework_TestCase
{
    /**
     * Site not found
     *
     * @expectedException GuzzleHttp\Exception\RequestException
     * 
     */
    public function testBadSite()
    {
        $url = "absolutelydefinitelynotarealdomaindskfjnhdaskjdfasjfds.com";

        $site = new Dribble($url);

        $site->go();
    }

    /**
     * Page not found 404
     *
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionCode 404
     *
     */
    public function testBadSitePage()
    {
        $url = "http://www.black-ink.org/notawebpagegdfs.html";

        $site = new Dribble($url);

        $site->go();
    }

    /**
     * Page found 200
     *
     */
    public function testGoodSitePage()
    {
        $url = "http://www.black-ink.org/";

        $site = new Dribble($url);

        $site->go();

        $this->assertEquals(true, $site->hasBody());
    }
}
?>