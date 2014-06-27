<?php namespace Laravelrus\Gitter;

class Gitter {

    protected $apiUrl = 'https://api.gitter.im/v1/';
    protected $userAgent = 'PHP Bot (http://walfire.ru)';
    protected $authCode;
    protected $roomId;

    /**
     * Constructor
     *
     * @param string $roomId
     * @param string $authCode
     */
    function __construct($roomId, $authCode)
    {
        $this->roomId = $roomId;
        $this->authCode = $authCode;
    }

    /**
     * Send message
     *
     * @param string $message
     * @return mixed
     * @throw InvalidArgumentException
     */
    public function sendMessage($message)
    {
        if ( ! is_scalar($message))
        {
            throw new \InvalidArgumentException('Message must be a scalar');
        }

        $response = $this->sendRequest($this->getRoomUrl('chatMessage'), array(
            'text' => $message
        ));

        return $response;
    }

    public function users()
    {
        $response = $this->sendRequest($this->getRoomUrl('users'));

        return $response;
    }

    public function channels()
    {
        $response = $this->sendRequest($this->getRoomUrl('channels'));

        return $response;
    }

    public function events()
    {
        $response = $this->sendRequest($this->getRoomUrl('events'));

        return $response;
    }

    public function rooms()
    {
        $response = $this->sendRequest($this->getRoomUrl());

        return $response;
    }

    /**
     * Send request
     *
     * @param string $url
     * @param array $data
     * @return mixed
     */
    protected function sendRequest($url, array $data = array())
    {
        if ( ! is_array($data))
        {
            throw new \InvalidArgumentException('Data must be an array or not set');
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, (string) $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $this->authCode,
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);

        if ($data)
        {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = json_decode(curl_exec($curl), true);

        curl_close($curl);

        return $response;
    }

    /**
     * Send client User Agent
     *
     * @param string $userAgent
     * @return $this
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get full Gitter Room Url
     *
     * @param string $type
     * @return string
     */
    protected function getRoomUrl($type = '')
    {
        return $this->apiUrl . 'rooms/' . $this->roomId . '/' . $type;
    }
}
