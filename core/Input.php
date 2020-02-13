<?php 
namespace Ultra;

class Input
{
    /**
     * IP address of the current user
     *
     * @var string
     */
    public static $ip_address = FALSE;
    
    /**
     * User agent strin
     *
     * @var string
     */
    public $user_agent = FALSE;

    /**
     * Allow GET array flag
     *
     * If set to FALSE, then $_GET will be set to an empty array.
     *
     * @var bool
     */
    protected $_allow_get_array = TRUE;
    
    /**
     * Input stream data
     *
     * Parsed from php://input at runtime
     *
     * @see CI_Input::input_stream()
     * @var array
     */
    protected $_input_stream = NULL;
    
    public function bootstrap()
    {
        // Sanitize global arrays
        // FIX ME // use saniteglobals if necessary
        // static::_sanitize_globals();
    }

    /**
     * Fetch from array
     *
     * Internal method used to retrieve values from global arrays.
     *
     * @param   array   &$array     $_GET, $_POST, $_COOKIE, $_SERVER, etc.
     * @param   string  $index      Index for item to be fetched from $array
     * @param   bool    $xss_clean  Whether to apply XSS filtering
     * @return  mixed
     */
    public static function _fetch_from_array(&$array, $index = '', $default=null, $xss_clean = FALSE)
    {
        if (isset($array[$index]))
        {
            $value = $array[$index];
        }
        elseif (($count = preg_match_all('/(?:^[^\[]+)|\[[^]]*\]/', $index, $matches)) > 1) // Does the index contain array notation
        {
            $value = $array;
            for ($i = 0; $i < $count; $i++)
            {
                $key = trim($matches[0][$i], '[]');
                if ($key === '') // Empty notation will return the value as array
                {
                    break;
                }

                if (isset($value[$key]))
                {
                    $value = $value[$key];
                }
                else
                {
                    return $default;
                }
            }
        }
        else
        {
            return $default;
        }

        return ($xss_clean === TRUE)
            ? static::$security->xss_clean($value)
            : $value;
    }

    /**
     * Fetch an item from the GET array
     *
     * @param   string  $index      Index for item to be fetched from $_GET
     * @param   bool    $xss_clean  Whether to apply XSS filtering
     * @return  mixed
     */
    public static function get($index = NULL, $default=null, $xss_clean = FALSE)
    {
        // Check if a field has been provided
        if ($index === NULL)
        {
            if (empty($_GET))
            {
                return array();
            }

            $get = array();

            // loop through the full _GET array
            foreach (array_keys($_GET) as $key)
            {
                $get[$key] = static::_fetch_from_array($_GET, $key, $default, $xss_clean);
            }
            return $get;
        }

        return static::_fetch_from_array($_GET, $index, $default, $xss_clean);
    }

    /**
     * Fetch an item from the POST array
     *
     * @param   string  $index      Index for item to be fetched from $_POST
     * @param   bool    $xss_clean  Whether to apply XSS filtering
     * @return  mixed
     */
    public static function post($index = NULL, $default=null, $xss_clean = FALSE)
    {
        // Check if a field has been provided
        if ($index === NULL)
        {
            if (empty($_POST))
            {
                return array();
            }

            $post = array();

            // Loop through the full _POST array and return it
            foreach (array_keys($_POST) as $key)
            {
                $post[$key] = static::_fetch_from_array($_POST, $key, $default, $xss_clean);
            }
            return $post;
        }

        return static::_fetch_from_array($_POST, $index, $default, $xss_clean);
    }

    /**
     * Fetch an item from POST data with fallback to GET
     *
     * @param   string  $index      Index for item to be fetched from $_POST or $_GET
     * @param   bool    $xss_clean  Whether to apply XSS filtering
     * @return  mixed
     */
    public static function get_post($index = '', $xss_clean = FALSE)
    {
        return isset($_POST[$index])
            ? static::post($index, $xss_clean)
            : static::get($index, $xss_clean);
    }

    public static function isMethod($method)
    {
        return ($method == $_SERVER['REQUEST_METHOD']);
    }

    public static function isGet()
    {
        return static::isMethod('GET');
    }

    public static function isPost()
    {
        return static::isMethod('POST');
    }

    /**
     * Fetch an item from the COOKIE array
     *
     * @param   string  $index      Index for item to be fetched from $_COOKIE
     * @param   bool    $xss_clean  Whether to apply XSS filtering
     * @return  mixed
     */
    public static function cookie($index = '', $default=null, $xss_clean = FALSE)
    {
        return static::_fetch_from_array($_COOKIE, $index, $default, $xss_clean);
    }

    /**
     * Fetch an item from the SERVER array
     *
     * @param   string  $index      Index for item to be fetched from $_SERVER
     * @param   bool    $xss_clean  Whether to apply XSS filtering
     * @return  mixed
     */
    public static function server($index = '', $default=null, $xss_clean = FALSE)
    {
        return static::_fetch_from_array($_SERVER, $index, $default, $xss_clean);
    }

    /**
     * Fetch an item from the php://input stream
     *
     * Useful when you need to access PUT, DELETE or PATCH request data.
     *
     * @param   string  $index      Index for item to be fetched
     * @param   bool    $xss_clean  Whether to apply XSS filtering
     * @return  mixed
     */
    public static function input_stream($index = '', $default=null, $xss_clean = FALSE)
    {
        // The input stream can only be read once, so we'll need to check
        // if we have already done that first.
        if (is_array(static::$_input_stream))
        {
            return static::_fetch_from_array(static::$_input_stream, $index, $default, $xss_clean);
        }

        // Parse the input stream in our cache var
        parse_str(file_get_contents('php://input'), static::$_input_stream);
        if ( ! is_array(static::$_input_stream))
        {
            static::$_input_stream = array();
            return NULL;
        }

        return static::_fetch_from_array(static::$_input_stream, $index, $default, $xss_clean);
    }

    /**
     * Fetch the IP Address
     *
     * Determines and validates the visitor's IP address.
     *
     * @return  string  IP address
     */
    public static function ip_address()
    {
        if (static::$ip_address !== FALSE)
        {
            return static::$ip_address;
        }

        $proxy_ips = ''; // FIX ME // get from config file after; // config_item('proxy_ips');
        if ( ! empty($proxy_ips) && ! is_array($proxy_ips))
        {
            $proxy_ips = explode(',', str_replace(' ', '', $proxy_ips));
        }

        static::$ip_address = static::server('REMOTE_ADDR');

        if ($proxy_ips)
        {
            foreach (array('HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'HTTP_X_CLIENT_IP', 'HTTP_X_CLUSTER_CLIENT_IP') as $header)
            {
                if (($spoof = static::server($header)) !== NULL)
                {
                    // Some proxies typically list the whole chain of IP
                    // addresses through which the client has reached us.
                    // e.g. client_ip, proxy_ip1, proxy_ip2, etc.
                    sscanf($spoof, '%[^,]', $spoof);

                    if ( ! static::valid_ip($spoof))
                    {
                        $spoof = NULL;
                    }
                    else
                    {
                        break;
                    }
                }
            }

            if ($spoof)
            {
                for ($i = 0, $c = count($proxy_ips); $i < $c; $i++)
                {
                    // Check if we have an IP address or a subnet
                    if (strpos($proxy_ips[$i], '/') === FALSE)
                    {
                        // An IP address (and not a subnet) is specified.
                        // We can compare right away.
                        if ($proxy_ips[$i] === static::$ip_address)
                        {
                            static::$ip_address = $spoof;
                            break;
                        }

                        continue;
                    }

                    // We have a subnet ... now the heavy lifting begins
                    isset($separator) OR $separator = static::valid_ip(static::$ip_address, 'ipv6') ? ':' : '.';

                    // If the proxy entry doesn't match the IP protocol - skip it
                    if (strpos($proxy_ips[$i], $separator) === FALSE)
                    {
                        continue;
                    }

                    // Convert the REMOTE_ADDR IP address to binary, if needed
                    if ( ! isset($ip, $sprintf))
                    {
                        if ($separator === ':')
                        {
                            // Make sure we're have the "full" IPv6 format
                            $ip = explode(':',
                                str_replace('::',
                                    str_repeat(':', 9 - substr_count(static::$ip_address, ':')),
                                    static::$ip_address
                                )
                            );

                            for ($i = 0; $i < 8; $i++)
                            {
                                $ip[$i] = intval($ip[$i], 16);
                            }

                            $sprintf = '%016b%016b%016b%016b%016b%016b%016b%016b';
                        }
                        else
                        {
                            $ip = explode('.', static::$ip_address);
                            $sprintf = '%08b%08b%08b%08b';
                        }

                        $ip = vsprintf($sprintf, $ip);
                    }

                    // Split the netmask length off the network address
                    sscanf($proxy_ips[$i], '%[^/]/%d', $netaddr, $masklen);

                    // Again, an IPv6 address is most likely in a compressed form
                    if ($separator === ':')
                    {
                        $netaddr = explode(':', str_replace('::', str_repeat(':', 9 - substr_count($netaddr, ':')), $netaddr));
                        for ($i = 0; $i < 8; $i++)
                        {
                            $netaddr[$i] = intval($netaddr[$i], 16);
                        }
                    }
                    else
                    {
                        $netaddr = explode('.', $netaddr);
                    }

                    // Convert to binary and finally compare
                    if (strncmp($ip, vsprintf($sprintf, $netaddr), $masklen) === 0)
                    {
                        static::$ip_address = $spoof;
                        break;
                    }
                }
            }
        }

        if ( ! static::valid_ip(static::$ip_address))
        {
            return static::$ip_address = '0.0.0.0';
        }

        return static::$ip_address;
    }

    /**
     * Validate IP Address
     *
     * @param   string  $ip IP address
     * @param   string  $which  IP protocol: 'ipv4' or 'ipv6'
     * @return  bool
     */
    public static function valid_ip($ip, $which = '')
    {
        switch (strtolower($which))
        {
            case 'ipv4':
                $which = FILTER_FLAG_IPV4;
                break;
            case 'ipv6':
                $which = FILTER_FLAG_IPV6;
                break;
            default:
                $which = NULL;
                break;
        }

        return (bool) filter_var($ip, FILTER_VALIDATE_IP, $which);
    }

    /**
     * Fetch User Agent string
     *
     * @return  string|null User Agent string or NULL if it doesn't exist
     */
    public static function user_agent()
    {
        if (static::$user_agent !== FALSE)
        {
            return static::$user_agent;
        }

        return static::$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL;
    }
}