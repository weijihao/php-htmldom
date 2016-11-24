<?php
namespace Weijihao\HtmlDom;

/**
 * All of the Defines for the classes below.
 * @author S.C. Chen <me578022@gmail.com>
 */
define('HDOM_TYPE_ELEMENT', 1);
define('HDOM_TYPE_COMMENT', 2);
define('HDOM_TYPE_TEXT',    3);
define('HDOM_TYPE_ENDTAG',  4);
define('HDOM_TYPE_ROOT',    5);
define('HDOM_TYPE_UNKNOWN', 6);
define('HDOM_QUOTE_DOUBLE', 0);
define('HDOM_QUOTE_SINGLE', 1);
define('HDOM_QUOTE_NO',     3);
define('HDOM_INFO_BEGIN',   0);
define('HDOM_INFO_END',     1);
define('HDOM_INFO_QUOTE',   2);
define('HDOM_INFO_SPACE',   3);
define('HDOM_INFO_TEXT',    4);
define('HDOM_INFO_INNER',   5);
define('HDOM_INFO_OUTER',   6);
define('HDOM_INFO_ENDSPACE',7);
define('DEFAULT_TARGET_CHARSET', 'UTF-8');//UTF-8
define('DEFAULT_BR_TEXT', "\r\n");
define('DEFAULT_SPAN_TEXT', " ");
define('MAX_FILE_SIZE', 600000);

//use Cake\Utility\Hash;

//helper functions
class HtmlDom
{

    /**
     * Does a recursive merge of the parameter with the scope config.
     *
     * @param array $options Options to merge.
     * @return array Options merged with set config.
     */
    protected function _mergeOptions($options)
    {
        return Hash::merge($this->_config, $options);
    }

    /**
     * [从文件中获取HTML DOM 对象] [get html dom from file]
     * $maxlen在代码中定义为PHP_STREAM_COPY_ALL，定义为-1. [$maxlen is defined in the code as PHP_STREAM_COPY_ALL which is defined as -1.]
     *
     */
    //public function file_get_html($url, $use_include_path = false, $context = null, $offset = -1, $maxLen = -1, $lowercase = true, $forceTagsClosed = true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN = true, $defaultBRText = DEFAULT_BR_TEXT, $defaultSpanText = DEFAULT_SPAN_TEXT)
    public function file_get_html($content, array $options = [])
    {

        $default = ['lowercase' => true,
                    'forceTagsClosed' => true,
                    'stripRN' => true,
                    'target_charset' => DEFAULT_TARGET_CHARSET,
                    'defaultBRText' => DEFAULT_BR_TEXT,
                    'defaultSpanText' => DEFAULT_SPAN_TEXT
                   ];

        $config = $this->_mergeOptions($default, $options);


        exit;

        // We DO force the tags to be terminated.
        $dom = new SimpleHtmlDom(null, $config['lowercase'], $config['forceTagsClosed'], $config['target_charset'], $stripRN, $defaultBRText, $defaultSpanText);
        // For sourceforge users: uncomment the next line and comment the retreive_url_contents line 2 lines down if it is not already done.
        /*
        $contents = file_get_contents($url, $use_include_path, $context, $offset);
        echo $encoding = mb_detect_encoding($contents, ['UTF-8', 'GB2312', 'GBK', 'ASCII']);
        //$contents = fopen($url, 'r');
        /*

        //var_dump($contents);
        if ($encoding && $encoding != 'UTF-8') {
            $contents = mb_convert_encoding($contents, 'GBK', 'GBK');
        }
        */
        // 创建一个新cURL资源
        $ch = curl_init();
        $options = [
                    CURLOPT_URL => $url,
                    CURLOPT_HEADER => false,
                    CURLOPT_CONNECTTIMEOUT => 5,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_MAXREDIRS => 3,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                ];
        curl_setopt_array($ch, $options);

        //curl_setopt($ch, CURLOPT_HEADER, 0);

        // 抓取URL并把它传递给浏览器
        $contents = curl_exec($ch);

        // 关闭cURL资源，并且释放系统资源
        curl_close($ch);

        //$contents = mb_convert_encoding($contents, 'UTF-8', 'GBK');

        //var_dump($contents);
        //exit;

        // Paperg - use our own mechanism for getting the contents as we want to control the timeout.
        //$contents = retrieve_url_contents($url);
        if (empty($contents) || strlen($contents) > MAX_FILE_SIZE) {
            return false;
        }
        // The second parameter can force the selectors to all be lowercase.
        $dom->load($contents, $lowercase, $stripRN);
        return $dom;
    }

    /**
     * get html dom from string
     * 中文翻译：
     *
     * @param $str
     * @param $lowercase
     * @param $forceTagsClosed
     * @param $target_charset
     *
     * @return void
     */
    public function str_get_html($str, $lowercase = true, $forceTagsClosed = true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN = true, $defaultBRText = DEFAULT_BR_TEXT, $defaultSpanText = DEFAULT_SPAN_TEXT)
    {
        $dom = new SimpleHtmlDom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
        if (empty($str) || strlen($str) > MAX_FILE_SIZE) {
            $dom->clear();
            return false;
        }
        $dom->load($str, $lowercase, $stripRN);

        return $dom;
    }

    /**
     * dump html dom tree
     * 中文翻译：
     *
     * @param $node
     * @param $show_attr
     * @param $deep
     *
     * @return void
     */
    public function dump_html_tree($node, $show_attr = true, $deep = 0)
    {
        $node->dump($node);
    }
}

