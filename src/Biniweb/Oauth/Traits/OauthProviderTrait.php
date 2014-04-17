<?php

namespace Biniweb\Oauth\Traits;

use Biniweb\Oauth\Constants\OauthCommonConstant;
use Biniweb\Oauth\Constants\OauthFacebookConstant;
use Biniweb\Oauth\Constants\OauthGoogleConstant;
use Biniweb\Oauth\Constants\OauthTwitterConstant;
use Biniweb\Oauth\Vo\OauthCallbackFacebookResponseVo;
use Biniweb\Oauth\Vo\OauthCallbackGoogleResponseVo;
use Biniweb\Oauth\Vo\OauthCallbackRequestVo;
use Biniweb\Oauth\Vo\OauthCallbackResponseVo;
use Biniweb\Oauth\Vo\OauthInitRequestVo;
use Biniweb\Oauth\Vo\OauthInitResponseVo;
use Biniweb\Oauth\Vo\OauthInitTwitterRequestVo;
use Biniweb\Oauth\Vo\OauthWebServiceRequestVo;

trait OauthProviderTrait
{
    #############################################

    /**
     * @param OauthInitRequestVo $vo
     * @return OauthInitResponseVo
     */
    protected function _initTwitter(OauthInitRequestVo $vo)
    {
        $response = $this->_parseInitTwitter($vo);

        if ($response !== FALSE) {

            $responseVo = new OauthInitTwitterRequestVo($response);

            if ($responseVo->hasOauthToken()) {

                $loginUrl = $this->_encodeUri(OauthTwitterConstant::AUTH_URL, [
                    'oauth_token' => $responseVo->getOauthToken(),
                ]);

                return new OauthInitResponseVo([
                    'provider' => $vo->getProvider(),
                    'login_url' => $loginUrl,
                ]);
            }
        }

        return FALSE;
    }

    #############################################

    /**
     * @param OauthInitRequestVo $vo
     * @return array|bool|mixed
     */
    private function _parseInitTwitter(OauthInitRequestVo $vo)
    {


        $signatureString =
            strtoupper(OauthCommonConstant::WEB_SERIVCE_REQUEST_TYPE_POST) .
            OauthCommonConstant::QUERYSTRING_SEPARETOR_PARAM .

            rawurlencode(OauthTwitterConstant::REQUEST_TOKEN_URL) .
            OauthCommonConstant::QUERYSTRING_SEPARETOR_PARAM .

            rawurlencode(
                'oauth_callback' .
                OauthCommonConstant::QUERYSTRING_SEPARETOR_VALUE .
                rawurlencode($vo->getRedirectUri()) .
                OauthCommonConstant::QUERYSTRING_SEPARETOR_PARAM .

                'oauth_consumer_key' .
                OauthCommonConstant::QUERYSTRING_SEPARETOR_VALUE .
                rawurlencode($vo->getClientId()) .
                OauthCommonConstant::QUERYSTRING_SEPARETOR_PARAM .

                'oauth_nonce' .
                OauthCommonConstant::QUERYSTRING_SEPARETOR_VALUE .
                rawurlencode(uniqid(rand())) .
                OauthCommonConstant::QUERYSTRING_SEPARETOR_PARAM .

                'oauth_signature_method' .
                OauthCommonConstant::QUERYSTRING_SEPARETOR_VALUE .
                rawurlencode(OauthTwitterConstant::LOGIN_SIGNATURE_METHOD) .
                OauthCommonConstant::QUERYSTRING_SEPARETOR_PARAM .

                'oauth_timestamp' .
                OauthCommonConstant::QUERYSTRING_SEPARETOR_VALUE .
                rawurlencode(time()) .
                OauthCommonConstant::QUERYSTRING_SEPARETOR_PARAM .

                'oauth_version' .
                OauthCommonConstant::QUERYSTRING_SEPARETOR_VALUE .
                rawurlencode(OauthTwitterConstant::LOGIN_VERSION)
            );

        $signatureKey =
            rawurlencode($vo->getClientSecret()) .
            OauthCommonConstant::QUERYSTRING_SEPARETOR_PARAM;

        $signature =
            base64_encode(
                hash_hmac(
                    OauthTwitterConstant::LOGIN_SIGNATURE_ALGORITHM,
                    $signatureString,
                    $signatureKey
                )
            );

//        var_dump($signatureString);
//        var_dump($signatureKey);
//        var_dump($signature);
//        var_dump(rawurlencode($signature));
//        exit;

        $requestVo = new OauthWebServiceRequestVo([
            'url' => OauthTwitterConstant::REQUEST_TOKEN_URL,
            'data' => [
                'oauth_nonce' => uniqid(rand()),
                'oauth_callback' => rawurlencode($vo->getRedirectUri()),
                'oauth_signature_method' => OauthTwitterConstant::LOGIN_SIGNATURE_METHOD,
                'oauth_timestamp' => time(),
                'oauth_consumer_key' => $vo->getClientId(),
                'oauth_signature' => rawurlencode($signature),
                'oauth_version' => OauthTwitterConstant::LOGIN_VERSION,
            ],
            'type_request' => OauthCommonConstant::WEB_SERIVCE_REQUEST_TYPE_POST,
            'type_response' => OauthCommonConstant::WEB_SERIVCE_RESPONSE_TYPE_GET,
        ]);

        return $this->_requestRestful($requestVo);
    }

    #############################################

    /**
     * @param OauthInitRequestVo $vo
     * @return OauthInitResponseVo
     */
    protected function _initGoogle(OauthInitRequestVo $vo)
    {
        $loginUrl = $this->_encodeUri(OauthGoogleConstant::AUTH_URL, [
            'redirect_uri' => urlencode($vo->getRedirectUri()),
            'response_type' => OauthGoogleConstant::LOGIN_REQUEST_TYPE,
            'client_id' => $vo->getClientId(),
            'scope' => urlencode(OauthGoogleConstant::LOGIN_SCOPE),
            'approval_prompt' => OauthGoogleConstant::LOGIN_APPROVAL_PROMPT,
            'access_type' => OauthGoogleConstant::LOGIN_ACCESS_TYPE,
        ]);

        return new OauthInitResponseVo([
            'provider' => $vo->getProvider(),
            'login_url' => $loginUrl,
        ]);
    }

    #############################################

    /**
     * @param OauthInitRequestVo $vo
     * @return OauthInitResponseVo
     */
    protected function _initFacebook(OauthInitRequestVo $vo)
    {
        $loginUrl = $this->_encodeUri(OauthFacebookConstant::AUTH_URL, [
            'client_id' => $vo->getClientId(),
            'redirect_uri' => urlencode($vo->getRedirectUri()),
            'scope' => OauthFacebookConstant::LOGIN_SCOPE,
            'response_type' => OauthFacebookConstant::LOGIN_REQUEST_TYPE,
        ]);

        return new OauthInitResponseVo([
            'provider' => $vo->getProvider(),
            'login_url' => $loginUrl,
        ]);
    }

    #############################################

    /**
     * @param $url
     * @param array $data
     * @return string
     */
    private function _encodeUri($url, array $data)
    {
        $parameters = [];
        foreach ($data as $key => $val) {
            $parameters[] = $key . OauthCommonConstant::QUERYSTRING_SEPARETOR_VALUE . $val;
        }

        if (!empty($parameters)) {
            $url .= OauthCommonConstant::QUERYSTRING_START_PARAM .
                join(OauthCommonConstant::QUERYSTRING_SEPARETOR_PARAM, $parameters);
        }

        return $url;
    }

    #############################################

    /**
     * @param $parametersString
     * @return array|bool
     */
    private function _decodeResponseParameters($parametersString)
    {
        $response = [];
        $parameters = explode(OauthCommonConstant::QUERYSTRING_SEPARETOR_PARAM, $parametersString);
        if (is_array($parameters)) {
            foreach ($parameters as $parameter) {
                $param = explode(OauthCommonConstant::QUERYSTRING_SEPARETOR_VALUE, $parameter);
                if (
                    isset($param[0])
                    && isset($param[1])
                ) {
                    $response[$param[0]] = $param[1];
                }
            }
        }

        if (!empty($response)) {
            return $response;
        }

        return FALSE;
    }

    #############################################

    /**
     * @param OauthCallbackRequestVo $vo
     * @return OauthCallbackResponseVo|bool
     */
    protected function _callbackFacebook(OauthCallbackRequestVo $vo)
    {
        $requestTokenUrl = $this->_encodeUri(OauthFacebookConstant::TOKEN_URL, [
            'client_id' => $vo->getClientId(),
            'redirect_uri' => $vo->getRedirectUri(),
            'client_secret' => $vo->getClientSecret(),
            'code' => $vo->getCode(),
        ]);
        $requestTokenVo = new OauthWebServiceRequestVo([
            'url' => $requestTokenUrl,
            'type_request' => OauthCommonConstant::WEB_SERIVCE_REQUEST_TYPE_GET,
            'type_response' => OauthCommonConstant::WEB_SERIVCE_RESPONSE_TYPE_ARRAY,
        ]);
        $responseTokenData = $this->_requestRestful($requestTokenVo);

        if ($responseTokenData !== FALSE) {

            $responseTokenVo = new OauthCallbackFacebookResponseVo($responseTokenData);

            if ($responseTokenVo->hasAccessToken() !== FALSE) {

                $requestUserDataUrl = $this->_encodeUri(OauthFacebookConstant::USER_DATA_URL, [
                    'access_token' => $responseTokenVo->getAccessToken(),
                ]);
                $requestUserDataVo = new OauthWebServiceRequestVo([
                    'url' => $requestUserDataUrl,
                    'type_request' => OauthCommonConstant::WEB_SERIVCE_REQUEST_TYPE_GET,
                    'type_response' => OauthCommonConstant::WEB_SERIVCE_RESPONSE_TYPE_JSON,
                ]);
                $responseUserData = $this->_requestRestful($requestUserDataVo);

                if ($responseUserData !== FALSE) {
                    return new OauthCallbackResponseVo($responseUserData);
                }
            }
        }

        return FALSE;
    }

    #############################################

    /**
     * @param OauthCallbackRequestVo $vo
     * @return OauthCallbackResponseVo|bool
     */
    protected function _callbackGoogle(OauthCallbackRequestVo $vo)
    {
        $requestTokenVo = new OauthWebServiceRequestVo([
            'url' => OauthGoogleConstant::TOKEN_URL,
            'data' => [
                'code' => urlencode($vo->getCode()),
                'redirect_uri' => urlencode($vo->getRedirectUri()),
                'client_id' => $vo->getClientId(),
                'scope' => urlencode(OauthGoogleConstant::LOGIN_SCOPE),
                'client_secret' => $vo->getClientSecret(),
                'grant_type' => OauthGoogleConstant::LOGIN_GRANT_TYPE,
            ],
            'type_request' => OauthCommonConstant::WEB_SERIVCE_REQUEST_TYPE_POST,
            'type_response' => OauthCommonConstant::WEB_SERIVCE_RESPONSE_TYPE_JSON,
        ]);
        $responseTokenData = $this->_requestRestful($requestTokenVo);

        if ($responseTokenData !== FALSE) {

            $responseTokenVo = new OauthCallbackGoogleResponseVo($responseTokenData);

            if ($responseTokenVo->hasAccessToken() !== FALSE) {

                $requestUserDataUrl = $this->_encodeUri(OauthGoogleConstant::USER_DATA_URL, [
                    'access_token' => $responseTokenVo->getAccessToken(),
                ]);
                $requestUserDataVo = new OauthWebServiceRequestVo([
                    'url' => $requestUserDataUrl,
                    'type_request' => OauthCommonConstant::WEB_SERIVCE_REQUEST_TYPE_GET,
                    'type_response' => OauthCommonConstant::WEB_SERIVCE_RESPONSE_TYPE_JSON,
                ]);

                $responseUserData = $this->_requestRestful($requestUserDataVo);

                if ($responseUserData !== FALSE) {
                    return new OauthCallbackResponseVo($responseUserData);
                }
            }
        }

        return FALSE;
    }

    #############################################

    /**
     * @param OauthCallbackRequestVo $vo
     * @return OauthCallbackResponseVo|bool
     */
    protected function _callbackTwitter(OauthCallbackRequestVo $vo)
    {
        $response = FALSE;

        if ($response !== FALSE) {
            return new OauthCallbackResponseVo($response);
        }

        return FALSE;
    }

    #############################################

    /**
     * @param OauthWebServiceRequestVo $vo
     * @return array|bool|string
     */
    private function _requestRestful(OauthWebServiceRequestVo $vo)
    {
        if ($vo->getTypeResponse() === OauthCommonConstant::WEB_SERIVCE_REQUEST_TYPE_POST) {
            $this->_createUri($vo);
        }

        $curl = \CURL::init($vo->getUrl())
            ->setReturnTransfer(TRUE);

        if ($vo->getTypeResponse() === OauthCommonConstant::WEB_SERIVCE_REQUEST_TYPE_JSON) {
            $curl->addHttpHeader('Content-type', 'application/json');
        }

        if ($vo->getTypeResponse() !== OauthCommonConstant::WEB_SERIVCE_REQUEST_TYPE_GET) {
            $curl->setPost(TRUE);
        }

        if ($vo->getTypeResponse() === OauthCommonConstant::WEB_SERIVCE_REQUEST_TYPE_JSON) {
            $curl->setPostFields(json_encode($vo->getData()));
        }

        if ($vo->getTypeResponse() === OauthCommonConstant::WEB_SERIVCE_REQUEST_TYPE_POST) {
            $curl->setPostFields(http_build_query($vo->getData()));
        }

        $vo->setWebServiceResponse($curl->execute());

        var_dump($vo->getWebServiceResponse());
        exit;

        $response = $this->_parseResponseRestful($vo);

        if (!empty($response)) {
            return $response;
        }

        return FALSE;
    }

    #############################################

    /**
     * @param OauthWebServiceRequestVo $vo
     * @return array|bool|string
     */
    private function _parseResponseRestful(OauthWebServiceRequestVo $vo)
    {
        switch ($vo->getTypeResponse()) {
            case OauthCommonConstant::WEB_SERIVCE_RESPONSE_TYPE_JSON;
                $response = (array)json_decode($vo->getWebServiceResponse(), TRUE);
                break;
            case OauthCommonConstant::WEB_SERIVCE_RESPONSE_TYPE_ARRAY;
                $response = (array)$this->_decodeResponseParameters($vo->getWebServiceResponse());
                break;
            case OauthCommonConstant::WEB_SERIVCE_RESPONSE_TYPE_TEXT:
                $response = $vo->getWebServiceResponse();
                break;
            case OauthCommonConstant::WEB_SERIVCE_RESPONSE_TYPE_GET:
                $response = (array)$_GET;
                break;
            case OauthCommonConstant::WEB_SERIVCE_RESPONSE_TYPE_POST:
                $response = (array)$_POST;
                break;
            default:
                $response = FALSE;
                break;
        }

        if ($response !== FALSE) {
            return $response;
        }

        return FALSE;
    }

    #############################################

    /**
     * @param OauthWebServiceRequestVo $vo
     */
    private function _createUri(OauthWebServiceRequestVo $vo)
    {
        $url = $vo->getUrl();
        $parameters = http_build_query($vo->getData());

        if (!empty($parameters)) {
            $url .= OauthCommonConstant::QUERYSTRING_START_PARAM . $parameters;
        }

        $vo->setUrl($url);
    }

} 