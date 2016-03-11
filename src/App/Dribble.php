<?php
/**
  * Class to handle site scraping 
  *
  * The section after the description contains the tags; which provide
  * structured meta-data concerning the given element.
  */

namespace App;

class Dribble 
{
    /**
     * Site url to be scraped
     *
     * @var string
     */
    protected $site_url;

    /**
     * Page body
     *
     * @var string
     */
    protected $body;

    /**
     * Parsed data
     *
     * @var string
     */
    protected $data;

    /**
     * Constructor
     *
     * @param string $url Site url
     */
    public function __construct($url)
    {
        // prepend protocol if does not exist

        if (!preg_match('/^https?:\/\//',$url)) {
            $url = 'http://' . $url;
        }

        $this->site_url = $url;
    }

    /**
     * Execute
     */
    public function go() 
    {
        $this->handleSite();
    }

    /**
     * Handle site page
     */
    protected function handleSite()
    {
        // @todo we're assuming exceptions handle everything for now so not check now
        $this->downloadPage();

        // @todo handle this not working
        $this->parsePage();
    }
    
    /**
     * Download the page
     *
     * @return bool status
     */
    protected function downloadPage()
    {    
        $client = new \GuzzleHttp\Client();

        // @todo can we assume all statuses other than 200 are handled by guzzle exceptions?

        $res = $client->get($this->site_url);

        $this->body = $res->getBody();
        
        // dev note: if you update this to possibly not return true, change handleSite()

        return true;
    }

    /**
     * Has a body - mostly for testing
     *
     * @return bool status
     */
    public function hasBody()
    {    
        return isset($this->body);
    }
    
    /**
     * Parse the page
     *
     * @return bool status
     */
    protected function parsePage()
    {    
        return true;
    }

    /**
     * Has a data - mostly for testing
     *
     * @return bool status
     */
    public function hasData()
    {    
        return isset($this->data);
    }
    
}

?>