<?php

namespace Biniweb\Oauth\Constants;

class OauthGoogleConstant
{
    const PROVIDER_NAME = 'google';
    const AUTH_URL = 'https://accounts.google.com/o/oauth2/auth';
    const TOKEN_URL = 'https://accounts.google.com/o/oauth2/token';
    const USER_DATA_URL = 'https://www.googleapis.com/userinfo/v2/me';
    const LOGIN_SCOPE = 'profile email';
    const LOGIN_REQUEST_TYPE = 'code';
    const LOGIN_APPROVAL_PROMPT = 'force';
    const LOGIN_GRANT_TYPE = 'authorization_code';
    const LOGIN_ACCESS_TYPE = 'offline';
}