<?php

namespace Biniweb\Oauth\Vo;

class OauthInitResponseVo
{
    /** @var  string */
    protected $_provider;

    /** @var  string */
    protected $_loginUrl;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->_provider = $data['provider'];
        $this->_loginUrl = $data['login_url'];
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
    public function getLoginUrl()
    {
        return $this->_loginUrl;
    }

} 