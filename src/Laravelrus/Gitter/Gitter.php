<?php namespace Laravelrus\Gitter;

class Gitter {

    protected $apiUrl = 'https://api.gitter.im/v1/';
    protected $userAgent = 'PHP Bot (http://walfire.ru)';
    protected $token;
    protected $roomId;

    /**
     * Constructor
     *
     * @param string $roomId
     * @param string $token
     */
    function __construct($roomId, $token)
    {
        $this->setToken($token);
        $this->setRoomId($roomId);
    }

    /**
     * Set Room ID
     *
     * @param string $roomId
     *
     * @throws \InvalidArgumentException if $roomId argument is not of type 'string'
     *
     * @return self
     */
    public function setRoomId($roomId)
    {
        if ( ! is_string($roomId))
        {
            throw new \InvalidArgumentException('Room ID must be a string');
        }

        $this->roomId = $roomId;

        return $this;
    }

    /**
     * Set Token
     *
     * @param string $token
     *
     * @throws \InvalidArgumentException if $token argument is not of type 'string'
     */
    public function setToken($token)
    {
        if ( ! is_string($token))
        {
            throw new \InvalidArgumentException('Token must be a string');
        }

        $this->token = $token;
    }

    /**
     * Send message
     *
     * @param GitterMessage $message
     *
     * @return array|null Return response
     */
    public function sendMessage(GitterMessage $message)
    {
        $response = $this->sendRequest($this->getRoomUrl('chatMessages'), $message);

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
     * @param GitterRequest $request
     *
     * @throws \InvalidArgumentException if $url argument is not of type 'string'
     *
     * @return array|null Return response
     */
    public function sendRequest($url, GitterRequest $request = null)
    {
        if ( ! is_string($url))
        {
            throw new \InvalidArgumentException('Url must be a string');
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->apiUrl . ltrim($url, '/'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $this->token,
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);

        if ($request)
        {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request->toJson());
        }

        $response = json_decode(curl_exec($curl), true);

        curl_close($curl);

        return $response;
    }

    /**
     * Set client User Agent
     *
     * @param string $userAgent
     *
     * @return self
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get room Url
     *
     * @param string $type
     *
     * @return string
     */
    protected function getRoomUrl($type = '')
    {
        return 'rooms/' . $this->roomId . '/' . $type;
    }
}
