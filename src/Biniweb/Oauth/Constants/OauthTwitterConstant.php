<?php

namespace Biniweb\Oauth\Constants;

class OauthTwitterConstant
{
    const PROVIDER_NAME = 'twitter';
    const REQUEST_TOKEN_URL = 'https://api.twitter.com/oauth/request_token';
    const AUTH_URL = 'https://api.twitter.com/oauth/authenticate';
    const TOKEN_URL = 'https://api.twitter.com/oauth/access_token';
    const LOGIN_SIGNATURE_METHOD = 'HMAC-SHA1';
    const LOGIN_SIGNATURE_ALGORITHM = 'sha1';
    const LOGIN_VERSION = '1.0';
}