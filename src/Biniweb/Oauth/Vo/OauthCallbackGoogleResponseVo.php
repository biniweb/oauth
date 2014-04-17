<?php

namespace Biniweb\Oauth\Vo;

class OauthCallbackGoogleResponseVo
{
    /** @var  string */
    protected $_accessToken;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->_accessToken = isset($data['access_token']) ? trim($data['access_token']) : NULL;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    /**
     * @return bool
     */
    public function hasAccessToken()
    {
        if (isset($this->_accessToken)) {
            return TRUE;
        }

        return FALSE;
    }
} 