# php-htmldom
PHP语言写的HTMLDOM

#安装步骤#

1、确保已经安装了 Composer 或者 下载了 composer.phar
```bash
composer require weijihao/php-htmldom
```
或者

在composer.json文件添加如下代码：
```bash
"require": {
    "weijihao/php-htmldom": "^0.1.0"
}
```

##调用插件##

1、在CakePHP里调用
```php
use Weijihao\HtmlDom\HtmlDom;

...
$htmlDom = new Weijihao\HtmlDom\HtmlDom();

$html = $htmlDom->str_get_html( $str );
//or
$html = $htmlDom->file_get_html( $file_name );

$elems = $html->find($elem_name);
...
```

2、在跟目录创建调用实例文件 index.php，代码如下：
```php
require_once "vendor/autoload.php";

$htmlDom = new Weijihao\HtmlDom\HtmlDom();

$html = $htmlDom->str_get_html('<div id="hello">Hello</div><div id="world">World</div>');

$html->find('div', 1)->class = 'bar';

echo $html->find('div[id=hello]', 0)->innertext;

echo "\n <br/>";

$html->find('div[id=hello]', 0)->innertext = 'foo';

echo $html; // Output: <div id="hello">foo</div><div id="world" class="bar">World</div>
$htmlDom->dump_html_tree($html);

//

$htmlDom = new Weijihao\HtmlDom\HtmlDom();

$htmDom = $htmlDom->file_get_html("http://www.baidu.com");

foreach ($htmDom->find('a') as $element) {
    echo $element->href . $element->innertext . '<br>';
}
```

