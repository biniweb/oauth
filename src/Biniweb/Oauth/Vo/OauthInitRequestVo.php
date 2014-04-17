<?php

namespace Biniweb\Oauth\Vo;

class OauthInitRequestVo
{
    /** @var  string */
    protected $_provider;

    /** @var  string */
    protected $_clientId;

    /** @var  string */
    protected $_clientSecret;

    /** @var  string */
    protected $_redirectUri;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->_provider = isset($data['provider']) ? trim($data['provider']) : NULL;
        $this->_clientId = isset($data['client_id']) ? trim($data['client_id']) : NULL;
        $this->_clientSecret = isset($data['client_secret']) ? trim($data['client_secret']) : NULL;
        $this->_redirectUri = isset($data['redirect_uri']) ? trim($data['redirect_uri']) : NULL;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->_provider;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->_clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->_clientSecret;
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->_redirectUri;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        if (isset($this->_provider)
            && isset($this->_clientId)
            && isset($this->_clientSecret)
            && isset($this->_redirectUri)
        ) {
            return TRUE;
        }

        return FALSE;
    }

} 