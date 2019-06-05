<?php

class User
{
    /**
     * @var string
     */
    private $ip;
    /**
     * @var string
     */
    private $agent;
    /**
     * @var string
     */
    private $url;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->ip = $this->extractIp();
        $this->agent = $_SERVER['HTTP_USER_AGENT'];
        $this->url = $_SERVER['HTTP_REFERER'];

    }

    /**
     * Extract visitor's IP
     *
     * @return string
     */
    private function extractIp()
    {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        return $ip;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
