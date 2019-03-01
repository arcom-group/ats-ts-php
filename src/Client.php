<?php
/**
 * ATS TS Client class
 */

namespace ATS\TS;

/**
 * ATS TS Client class
 */
class Client
{

    /**
     * Config parameter
     *
     * For example:
     * 
     * private $_config = [
     *    'server' => 'https://cloud.server.com',
     *    'username' => 'username',
     *    'key' => 'apikey',
     * ];
     * 
     * @var array
     */
    private $_config = [
        'server' => null,
        'username' => null,
        'key' => null,
        'exceptions' => true,
    ];

    /**
     * Api token
     *
     * @var string
     */
    private $token = null;

    /**
     * Construct function
     *
     * @param string $token
     * @param array $config
     */
    public function __construct($token, $config = [])
    {
        $this->token = $token;
        $this->_config = array_merge($this->_config, $config);
    }

    /**
     * Api requst method
     *
     * @param string $method
     * @param string $uri
     * @param array $params
     * @return array
     */
    public function api($method, $uri, $params = [])
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => $this->_config['server'],
            'exceptions' => $this->_config['exceptions'],
        ]);

        $headers = [];
        $token = $this->token;
        if ($token) {
            $headers = [
                'authorization' => 'Bearer '. $this->token,
            ];
        }

        try {
            $response = $client->request($method, $this->_config['server'] . $uri, [
                'headers' => $headers,
                'json' => strtoupper($method) !== 'GET' ? $params : [],
                'query' => strtoupper($method) == 'GET' ? $params : [],
                'allow_redirects' => true,
                'connect_timeout' => 4,
            ]);
        } catch (\GuzzleHttp\Exception\CurlException $e) {
            return [];
        }

        if (in_array($response->getStatusCode(), [200, 201, 202, 203, 204, 205])) {
            return json_decode((string)$response->getBody(), true);
        } elseif (in_array($response->getStatusCode(), [401])) {
            $this->token = null;
            return ['error' => 'unauthorized'];
        } else {
            return [];
        }
    }

    /**
     * Get available token
     *
     * @param array $params
     * @return void
     */
    public static function token($params)
    {
        $client = new Client(null, $params);

        $response = $client->api('POST', '/auth', array(
            'username' => $params['username'],
            'password' => $params['key'],
        ));
    
        return isset($response['id_token']) ? $response['id_token'] : null;
    }

    /**
     * GET method
     *
     * @param string $uri
     * @param array $params
     * @return void
     */
    public function get($uri, $params = [])
    {
        return $this->api('get', $uri, $params);
    }

    /**
     * POST method
     *
     * @param string $uri
     * @param array $params
     * @return void
     */
    public function post($uri, $params = [])
    {
        return $this->api('post', $uri, $params);
    }

    /**
     * PUT method
     *
     * @param string $uri
     * @param array $params
     * @return void
     */
    public function put($uri, $params = [])
    {
        return $this->api('put', $uri, $params);
    }

    /**
     * DELETE method
     *
     * @param string $uri
     * @param array $params
     * @return void
     */
    public function delete($uri, $params = [])
    {
        return $this->api('delete', $uri, $params);
    }

}
