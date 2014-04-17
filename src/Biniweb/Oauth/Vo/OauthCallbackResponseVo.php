<?php

namespace Biniweb\Oauth\Vo;

class OauthCallbackResponseVo
{
    /** @var  int */
    protected $_id;

    /** @var  string */
    protected $_email;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->_id = $data['id'];
        $this->_email = $data['email'];
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }


} 