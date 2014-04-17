<?php

namespace Biniweb\Oauth\Constants;

class OauthFacebookConstant
{
    const PROVIDER_NAME = 'facebook';
    const AUTH_URL = 'https://www.facebook.com/dialog/oauth';
    const TOKEN_URL = 'https://graph.facebook.com/oauth/access_token';
    const USER_DATA_URL = 'https://graph.facebook.com/me';
    const LOGIN_SCOPE = 'email';
    const LOGIN_REQUEST_TYPE = 'code';
} 