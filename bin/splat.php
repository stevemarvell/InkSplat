<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Dribble;
use GuzzleHttp\Exception\RequestException;

$url = "http://www.black-ink.org/notawebpage.html";

$site = new Dribble($url);

try 
{
    $site->go();
}
catch (RequestException $e) 
{
    # @todo more procesing to handle curl errors

    echo $e->getMessage() . "\n";
    exit;
}
catch (Exception $e)
{
    print $e->getMessage() . "\n";
    exit;
}
