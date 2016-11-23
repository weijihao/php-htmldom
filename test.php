<?php

require_once "vendor/autoload.php";

$htmlDom = new Weijihao\HtmlDom\HtmlDom();
$html = $htmlDom->str_get_html('<div id="hello">Hello</div><div id="world">World</div>');

$html->find('div', 1)->class = 'bar';

echo $html->find('div[id=hello]', 0)->innertext;

echo "\n <br/>";

$html->find('div[id=hello]', 0)->innertext = 'foo';

echo $html; // Output: <div id="hello">foo</div><div id="world" class="bar">World</div>
$htmlDom->dump_html_tree($html);


echo "\n <br/>";
echo "####################################################";
echo "\n <br/>";


$htmlDom = new Weijihao\HtmlDom\HtmlDom();

$htmDom = $htmlDom->file_get_html("http://www.it-school.cn");

foreach($htmDom->find('a') as $element) {
    echo $element->href . $element->innertext . '<br>';
}

