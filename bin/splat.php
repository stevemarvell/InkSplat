<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Dribble;
use App\ExResponseException;

use GuzzleHttp\Exception\RequestException;

// @todo make this a getopt

$url = "http://www.black-ink.org";

$site = new Dribble($url);

// these are fundamental erros we should consider managing elsewhere
// for convenience we present them as json now

try 
{
    $site->go();
    $data = $site->getData();
}
catch (RequestException $e) 
{
    // @todo more procesing to handle curl errors

    $error = [
              'code' => $e->getCode(),
              'message' => $e->getMessage(),
              'site' => $url,
              ];

    $data = [ 'errors' => [ $error ] ];
}
catch (ExResponseException $e) 
{
    // @todo more procesing to handle curl errors

    $error = [
              'code' => $e->getCode(),
              'message' => $e->getMessage(),
              'site' => $url,
              'url' => $e->getUrl()
              ];

    $data = [ 'errors' => [ $error ] ];
}
catch (Exception $e)
{
    $error = [
              'code' => $e->getCode(),
              'message' => $e->getMessage(),
              'site' => $url,
              ];

    $data = [ 'errors' => [ $error ] ];
}
// there is no finally in PHP5.4

# and now, with head held high, we print it to stdout

print json_encode($data,JSON_PRETTY_PRINT);

# roll credits

# and then a cheeky newline

print "\n";

# lights up, everyone goes home

// @todo take out silly comments (#)



