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
     * Site page body
     *
     * @var string
     */
    protected $site_body;

    /**
     * Parsed data
     *
     * @var string
     */
    protected $site_data;

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
        
        $html = $this->downloadSitePage();

        $dom = new \simple_html_dom();
        $dom->load($html);

        foreach ($dom->find('div[class=entry-wrap]') as $section) {

            $section_dom = new \simple_html_dom();
            $section_dom->load($section);

            $tag_good = false;

            foreach ($section_dom->find('a[rel=tag]') as $tag) {

                if (strpos($tag,'Digitalia') !== false) {
                    $tag_good = true;
                    break;
                }
            }

            if ($tag_good) {

                // looks like the only use of li

                foreach ($section_dom->find('li') as $item) {

                    if (preg_match('/href="([^"]+)"/',$item,$matches)) {                        
                        
                        $url = $matches[1];

                        $this->handleLink($url);
                    }
                }
            }
        }
    }
    
    protected function handleLink($url)
    {
        try {
            $html = $this->downloadPage($url);

            $dom = new \simple_html_dom();
            $dom->load($html);

            $result = [
                      'url' => $url,
                      'filesize' => strlen($html),
                      ];

            if (isset($this->site_data['results'])) {
                
                $this->site_data['results'][] = $result;

            } else {
                
                $this->site_data['results'] = [ $result ];
            }

        }
        catch (\Exception $e) {
                  
            $error = [
                      'code' => $e->getCode(),
                      'message' => $e->getMessage(),
                      'site' => $this->site_url,
                      'url' => $url
                      ];

            if (isset($this->site_data['errors'])) {
                
                $this->site_data['errors'][] = $error;

            } else {
                
                $this->site_data['errors'] = [ $error ];
            }
        }
    }

    /**
     * Download the site page
     *
     * public for testing
     *
     * @return string body
     */
    public function downloadSitePage()
    {    
        // we may wish to catch some specifics

        $this->site_body = $this->downloadPage($this->site_url);

        return $this->site_body;
    }

    /**
     * Download any page
     *
     * @return string body
     */
    protected function downloadPage($url)
    {    
        $client = new \GuzzleHttp\Client();

        // @todo check which guzzle creates an exception for all the things we want that we don't handle

        $request = $client->createRequest('GET', $url, ['allow_redirects' => false]);
        $response = $client->send($request);

        $code = $response->getStatusCode();
        
        if ($code != 200) {
            $e = new ExResponseException($response->getReasonPhrase(),$code);
            $e->setUrl($url);
            throw $e;
        }

        // @todo other types of response errors to handle

        return $response->getBody();
    }

    /**
     * Has a body - mostly for testing
     *
     * @return bool status
     */
    public function hasBody()
    {    
        return isset($this->site_body);
    }
    
    /**
     * Get data
     *
     * @return array data
     */
    public function getData()
    {    
        return $this->site_data;
    }
    
}

?>