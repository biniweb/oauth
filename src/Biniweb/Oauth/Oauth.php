<?php

namespace Biniweb\Oauth;

use Biniweb\Oauth\Constants\OauthFacebookConstant;
use Biniweb\Oauth\Constants\OauthGoogleConstant;
use Biniweb\Oauth\Constants\OauthTwitterConstant;
use Biniweb\Oauth\Traits\OauthProviderTrait;
use Biniweb\Oauth\Vo\OauthCallbackRequestVo;
use Biniweb\Oauth\Vo\OauthCallbackResponseVo;
use Biniweb\Oauth\Vo\OauthInitRequestVo;
use Biniweb\Oauth\Vo\OauthInitResponseVo;
use Simplon\Helper\SingletonTrait;
use Simplon\Helper\VoManyFactory;

class Oauth
{
    use SingletonTrait;
    use OauthProviderTrait;

    #############################################

    /**
     * @param OauthInitRequestVo[] $requestVoMany
     * @return OauthInitResponseVo[]|bool
     */
    public function init(array $requestVoMany)
    {
        /** @var OauthInitResponseVo[] $responseVoMany */
        $responseVoMany = VoManyFactory::factory($requestVoMany, function ($index, $vo) {

            /** @var OauthInitRequestVo $vo */

            if ($vo->isValid() !== FALSE) {

                $responseVo = $this->_parseInit($vo);

                if ($responseVo !== FALSE) {
                    return $responseVo;
                }
            }
        });

        if (!empty($responseVoMany)) {
            return $responseVoMany;
        }

        return FALSE;
    }

    #############################################

    /**
     * @param OauthInitRequestVo $vo
     * @return OauthInitResponseVo|bool
     */
    protected function _parseInit(OauthInitRequestVo $vo)
    {
        switch ($vo->getProvider()) {
            case OauthFacebookConstant::PROVIDER_NAME:
                $response = $this->_initFacebook($vo);
                break;
            case OauthGoogleConstant::PROVIDER_NAME:
                $response = $this->_initGoogle($vo);
                break;
            case OauthTwitterConstant::PROVIDER_NAME:
                $response = $this->_initTwitter($vo);
                break;
            default:
                $response = FALSE;
                break;
        }

        return $response;
    }

    #############################################

    /**
     * @param OauthCallbackRequestVo $vo
     * @return OauthCallbackResponseVo|bool
     */
    public function callback(OauthCallbackRequestVo $vo)
    {
        if ($vo->isValid() !== FALSE) {

            $callbackResponseVo = $this->_parseCallback($vo);

            if ($callbackResponseVo !== FALSE) {
                return $callbackResponseVo;
            }
        }

        return FALSE;
    }

    #############################################

    /**
     * @param OauthCallbackRequestVo $vo
     * @return OauthCallbackResponseVo|bool
     */
    protected function _parseCallback(OauthCallbackRequestVo $vo)
    {
        switch ($vo->getProvider()) {
            case OauthFacebookConstant::PROVIDER_NAME:
                $responseVo = $this->_callbackFacebook($vo);
                break;
            case OauthGoogleConstant::PROVIDER_NAME:
                $responseVo = $this->_callbackGoogle($vo);
                break;
            case OauthTwitterConstant::PROVIDER_NAME:
                $responseVo = $this->_callbackTwitter($vo);
                break;
            default:
                $responseVo = FALSE;
                break;
        }

        return $responseVo;
    }

}