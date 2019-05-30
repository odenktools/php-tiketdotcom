<?php

namespace Tiket;

use Carbon\Carbon;
use Unirest\Request;
use Unirest\Request\Body;

/**
 * Tiket REST API Library.
 *
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2019, Pribumi Technology
 */
class TiketHttp
{
    public static $VERSION = '1.0.0';

    /**
     * Default Timezone.
     *
     * @var string
     */
    private static $timezone = 'Asia/Jakarta';

    /**
     * Default Tiket Port.
     *
     * @var int
     */
    private static $port = 443;

    /**
     * Default Tiket Host.
     *
     * @var string
     */
    private static $hostName = 'api-sandbox.tiket.com';

    /**
     * Default Tiket Host.
     *
     * @var string
     */
    private static $scheme = 'https';

    /**
     * Timeout curl.
     *
     * @var int
     */
    private static $timeOut = 60;

    /**
     * Auth Token.
     *
     * @var int
     */
    private static $authToken;

    /**
     * Default Curl Options.
     *
     * @var int
     */
    private static $curlOptions = [
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSLVERSION => 6,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 60
    ];

    /**
     * Default Tiket Settings.
     *
     * @var array
     */
    protected $settings = array(
        'business_id' => '',
        'business_name' => '',
        'client_secret' => '',
        'headers-agent' => '',
        'curl_options' => array(),
        'options' => array(
            'host' => 'api-sandbox.tiket.com',
            'scheme' => 'https',
            'timeout' => 60,
            'port' => 443,
            'timezone' => 'Asia/Jakarta'
        )
    );

    /**
     * Default Constructor.
     *
     * @param string $client_secret nilai client secret
     * @param string $business_id nilai business id
     * @param string $business_name nilai business name
     * @param array $options opsi ke server tiket
     */
    public function __construct($client_secret, $business_id, $business_name, array $options = [])
    {
        if (!isset($options['host'])) {
            $options['host'] = 'api-sandbox.tiket.com';
        }
        // Setup optional port, if port is empty
        if (isset($options['port'])) {
            $this->settings['options']['port'] = $options['port'];
        } else {
            $this->settings['options']['port'] = self::getPort();
        }
        // Setup optional scheme, if scheme is empty
        if (isset($options['scheme'])) {
            $this->settings['options']['scheme'] = $options['scheme'];
        } else {
            $this->settings['options']['scheme'] = self::getScheme();
        }
        // Setup optional timezone, if timezone is empty
        if (isset($options['timezone'])) {
            $this->settings['options']['timezone'] = $options['timezone'];
        } else {
            $this->settings['options']['timezone'] = self::getHostName();
        }
        // Setup optional timeout, if timeout is empty
        if (isset($options['timeout'])) {
            $this->settings['options']['timeout'] = $options['timeout'];
        } else {
            $this->settings['options']['timeout'] = self::getTimeOut();
        }
        foreach ($options as $key => $value) {
            if (isset($this->settings[$key])) {
                $this->settings[$key] = $value;
            }
        }
        $this->settings['client_secret'] = $client_secret;
        $this->settings['business_id'] = $business_id;
        $this->settings['business_name'] = $business_name;
        $this->settings['headers-agent'] = 'twh:' . $this->settings['business_id'] . ';' . $this->settings['business_name'] . ';';

        // Set Default Curl Options.
        Request::curlOpts(self::$curlOptions);

        // Set custom curl options
        if (!empty($this->settings['curl_options'])) {
            $data = self::mergeCurlOptions(self::$curlOptions, $this->settings['curl_options']);
            Request::curlOpts($data);
        }
    }

    /**
     * Ambil Nilai settings.
     *
     * @return array
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Build the ddn domain.
     * output = 'https://api-sandbox.tiket.com:443'
     * scheme = http(s)
     * host = api-sandbox.tiket.com
     * port = 80 ? 443
     *
     * @return string
     */
    private function ddnDomain()
    {
        return $this->settings['options']['scheme'] . '://' . $this->settings['options']['host'] . ':' .
            $this->settings['options']['port'] . '/';
    }

    /**
     * Get TimeZone.
     *
     * @return string
     */
    public static function getTimeZone()
    {
        return self::$timezone;
    }

    /**
     * Set TimeZone.
     *
     * @param string $timeZone Time yang akan dipergunakan.
     *
     * @return string
     */
    public static function setTimeZone($timeZone)
    {
        self::$timezone = $timeZone;
    }

    /**
     * Ambil nama domain Tiket yang akan dipergunakan.
     *
     * @return string
     */
    public static function getHostName()
    {
        return self::$hostName;
    }

    /**
     * Set nama domain Tiket yang akan dipergunakan.
     *
     * @param string $hostName nama domain Tiket yang akan dipergunakan.
     *
     * @return string
     */
    public static function setHostName($hostName)
    {
        self::$hostName = $hostName;
    }

    /**
     * Ambil Auth Token.
     *
     * @return string
     */
    public static function getAuthToken()
    {
        return self::$authToken;
    }

    /**
     * Set Auth Token.
     *
     * @param string $token Auth token.
     *
     * @return string
     */
    public static function setAuthToken($token)
    {
        self::$authToken = $token;
        return self::$authToken;
    }

    /**
     * Ambil maximum execution time.
     *
     * @return string
     */
    public static function getTimeOut()
    {
        return self::$timeOut;
    }

    /**
     * Set Ambil maximum execution time.
     *
     * @param int $timeOut timeout in milisecond.
     *
     * @return string
     */
    public static function setTimeOut($timeOut)
    {
        self::$timeOut = $timeOut;
        return self::$timeOut;
    }

    /**
     * Get Tiket port
     *
     * @return int
     */
    public static function getPort()
    {
        return self::$port;
    }

    /**
     * Set Tiket port
     *
     * @param int $port Port yang akan dipergunakan
     *
     * @return int
     */
    public static function setPort($port)
    {
        self::$port = $port;
    }

    /**
     * Get Tiket Schema
     *
     * @return string
     */
    public static function getScheme()
    {
        return self::$scheme;
    }


    /**
     * Set Tiket Schema
     *
     * @param int $scheme Scheme yang akan dipergunakan
     *
     * @return string
     */
    public static function setScheme($scheme)
    {
        self::$scheme = $scheme;
    }

    /**
     * Ambil nama domain Tiket yang akan dipergunakan.
     *
     * @return string
     */
    public static function getCurlOptions()
    {
        return self::$curlOptions;
    }

    /**
     * Setup curl options.
     *
     * @param array $curlOpts
     * @return array
     */
    public static function setCurlOptions(array $curlOpts = [])
    {
        $data = self::mergeCurlOptions(self::$curlOptions, $curlOpts);
        self::$curlOptions = $data;
    }

    /**
     * Generate authentifikasi ke server berupa OAUTH.
     *
     * @return \Unirest\Response
     */
    public function httpAuth()
    {
        $request_path = "apiv1/payexpress";
        $domain = $this->ddnDomain();
        $full_url = $domain . $request_path;
        $data = array();
        $data['method'] = 'getToken';
        $data['secretkey'] = $this->settings['client_secret'];
        $data['output'] = 'json';
        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'user-agent' => $this->settings['headers-agent']
        );
        $response = \Unirest\Request::get($full_url, $headers, $data);
        return $response->body->token;
    }

    /**
     * Ambil List currency.
     *
     * @return \Unirest\Response
     */
    public function getListCurrency()
    {
        $request_path = "general_api/listCurrency";
        $domain = $this->ddnDomain();
        $full_url = $domain . $request_path;
        $token = self::getAuthToken();
        $data = array();
        $data['token'] = $token;
        $data['output'] = 'json';
        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'user-agent' => $this->settings['headers-agent']
        );
        $response = \Unirest\Request::get($full_url, $headers, $data);

        return $response;
    }

    /**
     * Ambil List Bahasa.
     *
     * @param string $oauth_token nilai token yang telah didapatkan setelah login
     *
     * @return \Unirest\Response
     */
    public function getListLanguage()
    {
        $request_path = "general_api/listLanguage";
        $domain = $this->ddnDomain();
        $full_url = $domain . $request_path;
        $token = self::getAuthToken();

        $data = array();
        $data['token'] = $token;
        $data['output'] = 'json';
        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'user-agent' => $this->settings['headers-agent']
        );
        $response = \Unirest\Request::get($full_url, $headers, $data);

        return $response;
    }

    /**
     * Ambil List Negara.
     *
     * @param string $token nilai token yang telah didapatkan setelah login
     * @param string $orderId Id order.
     * @param string $email email
     *
     * @return \Unirest\Response
     */
    public function getListCountry($token, $orderId, $email)
    {
        $request_path = "general_api/listCountry";
        $domain = $this->ddnDomain();
        $full_url = $domain . $request_path;

        $data = array();
        $data['order_id'] = $orderId;
        $data['email'] = $email;
        $data['token'] = $token;
        $data['output'] = 'json';
        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'user-agent' => $this->settings['headers-agent']
        );
        $response = \Unirest\Request::get($full_url, $headers, $data);

        return $response;
    }

    /**
     * You use this parameter if you want to pay the current user using your deposit.
     *
     * @param string $confirmKey kode konfirmasi
     * @param string $username nama user
     * @return \Unirest\Response
     */
    public function getSaldo($confirmKey, $username)
    {
        $request_path = "partner/transactionApi/get_saldo";
        $domain = $this->ddnDomain();
        $full_url = $domain . $request_path;

        $data = array();
        $client_secret = $this->settings['client_secret'];
        $data['secretkey'] = $client_secret;
        $data['confirmkey'] = $confirmKey;
        $data['username'] = $username;
        $data['output'] = 'json';
        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'user-agent' => $this->settings['headers-agent']
        );
        $response = \Unirest\Request::get($full_url, $headers, $data);

        return $response;
    }

    /**
     * You use this parameter if you want to pay the current user using your deposit.
     *
     * @param string $token token login.
     * @param string $id todo
     * @param string $btnBooking flag for continue
     *
     * @return \Unirest\Response
     */
    public function getCheckoutPayment($token, $id = '8', $btnBooking = '1')
    {
        $request_path = "checkout/checkout_payment/$id";
        $domain = $this->ddnDomain();
        $full_url = $domain . $request_path;
        $data = array();
        $data['btn_booking'] = $btnBooking;
        $data['token'] = $token;
        $data['output'] = 'json';
        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'user-agent' => $this->settings['headers-agent']
        );
        $response = \Unirest\Request::get($full_url, $headers, $data);

        return $response;
    }

    /**
     * To get List deposit transaction.
     *
     * @param string $confirmkey todo
     * @param string $username todo
     *
     * @return \Unirest\Response
     */
    public function getShowTransactionApi($confirmkey, $username)
    {
        $request_path = "partner/transactionApi";
        $domain = $this->ddnDomain();
        $full_url = $domain . $request_path;

        $data = array();
        $client_secret = $this->settings['client_secret'];
        $data['secretkey'] = $client_secret;
        $data['confirmkey'] = $confirmkey;
        $data['username'] = $username;
        $data['output'] = 'json';
        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'user-agent' => $this->settings['headers-agent']
        );
        $response = \Unirest\Request::get($full_url, $headers, $data);

        return $response;
    }

    /**
     * Confirm Transaction by API.
     *
     * @param string $orderId Order id
     * @param string $confirmkey confirmkey given by Tiket.com
     * @param string $username your username as the one who link to the business
     * @param string $textarea_note note for the confirmation
     * @param string $tanggal confirmation date YYYY-MM-DD
     *
     * @return \Unirest\Response
     */
    public function getConfirmPayment($orderId, $confirmkey, $username, $textarea_note, $tanggal)
    {
        $request_path = "partner/transactionApi/confirmPayment";
        $domain = $this->ddnDomain();
        $full_url = $domain . $request_path;

        $data = array();
        $client_secret = $this->settings['client_secret'];

        $data['order_id'] = $orderId;
        $data['secretkey'] = $client_secret;
        $data['confirmkey'] = $confirmkey;
        $data['username'] = $username;
        $data['textarea_note'] = $textarea_note;
        $data['tanggal'] = $tanggal;
        $data['output'] = 'json';
        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'user-agent' => $this->settings['headers-agent']
        );
        $response = \Unirest\Request::get($full_url, $headers, $data);

        return $response;
    }

    /**
     * Flight Search.
     *
     * @param string $token for saving transaction that done by user
     * @param string $departureCode Departure airport code
     * @param string $arrivalCode Arrival airport code
     * @param string $departDate YYYY-MM-DD, Depart date Result will be in
     * @param string $returnDate YYYY-MM-DD, Return date If provided, then system will return
     * @param int $adult number of adult passenger
     * @param int $child number of child passenger
     * @param int $infant number of infant passenger
     * @param int $version version of the search
     *
     * @return \Unirest\Response
     */
    public function getFlightSearch($token, $departureCode, $arrivalCode, $departDate, $returnDate, $adult = 1, $child = 0, $infant = 0, $version = 3)
    {
        $request_path = "search/flight";
        $domain = $this->ddnDomain();
        $full_url = $domain . $request_path;

        $data = array();
        $data['token'] = $token;
        $data['d'] = $departureCode;
        $data['a'] = $arrivalCode;
        $data['date'] = $departDate;
        if ($returnDate !== '') {
            $data['ret_date'] = $returnDate;
        }
        $data['adult'] = $adult;
        if ($returnDate !== '') {
            $data['ret_date'] = $returnDate;
        }
        if ($child !== 0) {
            $data['child'] = $child;
        }
        if ($infant !== 0) {
            $data['infant'] = $infant;
        }
        $data['v'] = $version;
        $data['output'] = 'json';

        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'user-agent' => $this->settings['headers-agent']
        );

        $response = \Unirest\Request::get($full_url, $headers, $data);

        return $response->body;
    }

    /**
     *
     * @param $token
     * @param string $flightId
     * @param string $date date want to travel
     * @param string $retFlightId
     * @param string $retDate
     * @return \Unirest\Response
     */
    public function getFlightData($token, $flightId, $date, $retFlightId, $retDate)
    {
        $request_path = "search/flight";
        $domain = $this->ddnDomain();
        $full_url = $domain . $request_path;

        $data = array();
        $data['token'] = $token;
        $data['flight_id'] = $flightId;
        $data['date'] = $date;
        $data['ret_flight_id'] = $retFlightId;
        $data['ret_date'] = $retDate;
        $data['output'] = 'json';

        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'user-agent' => $this->settings['headers-agent']
        );

        $response = \Unirest\Request::get($full_url, $headers, $data);

        return $response;
    }

    /**
     * @param $token
     * @return \Unirest\Response
     */
    public function getFlightSearchAirport($token)
    {
        $request_path = "flight_api/all_airport";
        $domain = $this->ddnDomain();
        $full_url = $domain . $request_path;
        $data = array();
        $data['token'] = $token;
        $data['output'] = 'json';

        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'user-agent' => $this->settings['headers-agent']
        );

        $response = \Unirest\Request::get($full_url, $headers, $data);

        return $response;
    }

    /**
     *
     * @param string $token
     * @param string $ip
     * @return \Unirest\Response
     */
    public function getFlightNearestAirportByIp($token, $ip)
    {
        $request_path = "flight_api/all_airport";
        $domain = $this->ddnDomain();
        $full_url = $domain . $request_path;
        $data = array();
        $data['token'] = $token;
        $data['ip'] = $ip;
        $data['output'] = 'json';

        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'user-agent' => $this->settings['headers-agent']
        );

        $response = \Unirest\Request::get($full_url, $headers, $data);

        return $response;
    }

    /**
     *
     * @param string $token
     * @param string $latitude latitude position user
     * @param string $longitude latitude position user
     * @return \Unirest\Response
     */
    public function getFlightNearestAirportByLongLat($token, $latitude, $longitude)
    {
        $request_path = "flight_api/all_airport";
        $domain = $this->ddnDomain();
        $full_url = $domain . $request_path;
        $data = array();
        $data['token'] = $token;
        $data['latitude'] = $latitude;
        $data['longitude'] = $longitude;
        $data['output'] = 'json';

        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'user-agent' => $this->settings['headers-agent']
        );

        $response = \Unirest\Request::get($full_url, $headers, $data);

        return $response;
    }

    /**
     * Generate ISO8601 Time.
     *
     * @param string $timeZone Time yang akan dipergunakan
     *
     * @return string
     */
    public static function generateIsoTime()
    {
        $date = Carbon::now(self::getTimeZone());
        date_default_timezone_set(self::getTimeZone());
        $fmt = $date->format('Y-m-d\TH:i:s');
        $ISO8601 = sprintf("$fmt.%s%s", substr(microtime(), 2, 3), date('P'));

        return $ISO8601;
    }

    /**
     * Merge from existing array.
     *
     * @param array $existing_options
     * @param array $new_options
     * @return array
     */
    private static function mergeCurlOptions(&$existing_options, $new_options)
    {
        $existing_options = $new_options + $existing_options;
        return $existing_options;
    }

    /**
     * Implode an array with the key and value pair giving
     * a glue, a separator between pairs and the array
     * to implode.
     *
     * @param string $glue The glue between key and value
     * @param string $separator Separator between pairs
     * @param array $array The array to implode
     *
     * @throws TiketHttpException error
     * @return string The imploded array
     */
    public static function arrayImplode($glue, $separator, $array = [])
    {
        if (!is_array($array)) {
            throw new TiketHttpException('Data harus array.');
        }
        if (empty($array)) {
            throw new TiketHttpException('parameter array tidak boleh kosong.');
        }
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $val = implode(',', $val);
            }
            $string[] = "{$key}{$glue}{$val}";
        }

        return implode($separator, $string);
    }
}
