<?php

namespace Biniweb\Oauth\Vo;

class OauthWebServiceRequestVo
{
    /** @var  string */
    protected $_url;

    /** @var  array */
    protected $_data;

    /** @var  string */
    protected $_typeRequest;

    /** @var  string */
    protected $_typeResponse;

    /** @var  string */
    private $_webServiceResponse;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->_url = isset($data['url']) ? $data['url'] : NULL;
        $this->_data = isset($data['data']) ? $data['data'] : NULL;
        $this->_typeRequest = isset($data['type_request']) ? $data['type_request'] : NULL;
        $this->_typeResponse = isset($data['type_response']) ? $data['type_response'] : NULL;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @return string
     */
    public function getTypeRequest()
    {
        return $this->_typeRequest;
    }

    /**
     * @return string
     */
    public function getTypeResponse()
    {
        return $this->_typeResponse;
    }

    /**
     * @param string $webServiceResponse
     */
    public function setWebServiceResponse($webServiceResponse)
    {
        $this->_webServiceResponse = $webServiceResponse;
    }

    /**
     * @return string
     */
    public function getWebServiceResponse()
    {
        return $this->_webServiceResponse;
    }

    /**
     * @return bool
     */
    public function hasData()
    {
        if (isset($this->_data)) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->_url = $url;
    }


} 