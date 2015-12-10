<?php

header('Content-Type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

$query	= isset($_GET['q']) ? $_GET['q'] : 'Пушкин';
$format	= isset($_GET['f']) ? $_GET['f'] : 'json';

defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/'));


include 'Logger.php';
include 'BrowserAdapter.php';
include 'BrowserCurl.php';
include 'simplehtmldom/simple_html_dom.php';
include 'Parser.php';

$br = new Ap_Browser_BrowserCurl();
$url = 'http://193.27.243.130/cgi-bin/irbis64r_91/cgiirbis_64.exe';
$params = array(
    'X_S21P03' => 'K=',
    'I21DBN' => 'IBIS',
    'P21DBN' => 'IBIS',
    'X_S21STR' => $query,
    'X_S21P01' => '4',
    'X_S21P02' => '1',
    'X_S21LOG' => '1',
    'S21COLORTERMS' => '1',
    'S21FMT' => 'infow_wh',
    'S21STN' => '1',
    'S21CNR' => '20',
    'S21REF' => '3',
    'C21COM' => 'S',
    'C21COM1' => 'Поиск'
);
$br->post($url, $params);

$html = str_get_html($br->getResponseText());

$res = array();

// find all link
foreach($html->find('.advanced tr td[width="95%"]') as $e)
{
    $str = str_replace('<br>', "\n", $e->innertext);
    $str =  strip_tags($str, '<b></b>');
    $res[] = $str;
}

$parser = new Parser();
$parsedResult = $parser->process($res);

if ($format == 'json')
{
	echo json_encode($parsedResult);
}
else
{
	Logger::dump($parsedResult);
}