<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Dribble;
use GuzzleHttp\Exception\RequestException;

// @todo make this a getopt

$url = "http://www.black-ink.org";

$site = new Dribble($url);

try 
{
    $data = $site->go();
}
catch (RequestException $e) 
{
    # @todo more procesing to handle curl errors

    $error = [
              'code' => $e->getCode() ?: 999,
              'message' => $e->getMessage()
              ];

    $data = [ 'error' => $error ];
}
catch (Exception $e)
{
    $error = [
              'code' => $e->getCode() ?: 999,
              'message' => $e->getMessage()
              ];

    $data = [ 'error' => $error ];
}
// there is no finally in PHP5.4

# and now, with head held high, we print it to stdout

print json_encode($data,JSON_PRETTY_PRINT);

# roll credits

# and then a cheeky newline

print "\n";

# lights up, everyone go home

// @todo take out silly comments (#)



