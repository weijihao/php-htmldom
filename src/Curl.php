<?php
namespace Weijihao\HtmlDom;

class Curl
{
    /**
     *
     *
     *
     */
    public function __construct()
    {

    }

    static public function getByCurl($url)
    {
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
                    //CURLOPT_HEADER => 0,
                ];
        curl_setopt_array($ch, $options);
        // 抓取URL并把它传递给浏览器
        $content = curl_exec($ch);
        // 关闭cURL资源，并且释放系统资源
        curl_close($ch);
        return $content;
    }

    /**
     *
     *
     *
     *
     */
    static public function getByFileGetContents($url, $use_include_path, $context, $offset)
    {
        $content = file_get_contents($url, $use_include_path, $context, $offset);

        return $content;
    }
}
