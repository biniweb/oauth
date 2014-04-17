<?php

namespace Biniweb\Oauth\Vo;

class OauthInitTwitterRequestVo
{
    /** @var  string */
    protected $_oauthToken;

    /** @var  string */
    protected $_oauthTokenSecret;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->_oauthToken = isset($data['oauth_token']) ? trim($data['oauth_token']) : NULL;
        $this->_oauthTokenSecret = isset($data['oauth_token_secret']) ? trim($data['oauth_token_secret']) : NULL;
    }

    /**
     * @return string
     */
    public function getOauthToken()
    {
        return $this->_oauthToken;
    }

    /**
     * @return bool
     */
    public function hasOauthToken()
    {
        if (isset($this->_oauthToken)) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * @return string
     */
    public function getOauthTokenSecret()
    {
        return $this->_oauthTokenSecret;
    }

} 