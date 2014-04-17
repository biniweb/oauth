<?php

class OauthUnitTest extends PHPUnit_Framework_TestCase
{
    use \Biniweb\Oauth\Traits\OauthProviderTrait;

    #############################################

    /** @var  \Biniweb\Oauth\Vo\OauthInitRequestVo */
    protected $_initFacebookVo;

    /** @var  \Biniweb\Oauth\Vo\OauthInitRequestVo */
    protected $_initGoogleVo;

    /** @var  \Biniweb\Oauth\Vo\OauthInitRequestVo */
    protected $_initTwitterVo;

    #############################################

    protected function setUp()
    {
        $this->_initFacebookVo = new \Biniweb\Oauth\Vo\OauthInitRequestVo([
            'provider' => \Biniweb\Oauth\Constants\OauthFacebookConstant::PROVIDER_NAME,
            'client_id' => '300263943457782',
            'client_secret' => '59730437e6b859da5543fed1acfb90ea',
            'redirect_uri' => 'http://framework.local/oauth/examples/callback.php?provider=facebook',
        ]);

        $this->_initGoogleVo = new \Biniweb\Oauth\Vo\OauthInitRequestVo([
            'provider' => \Biniweb\Oauth\Constants\OauthGoogleConstant::PROVIDER_NAME,
            'client_id' => '454280071961.apps.googleusercontent.com',
            'client_secret' => 'L5xhfzCOabDt37Qp-BQ5BQZ9',
            'redirect_uri' => 'http://framework.local/oauth/examples/callback.php?provider=google',
        ]);

        $this->_initTwitterVo = new \Biniweb\Oauth\Vo\OauthInitRequestVo([
            'provider' => \Biniweb\Oauth\Constants\OauthTwitterConstant::PROVIDER_NAME,
            'client_id' => 'HrO0irPBb4rUm3nmuLOp41lwQ',
            'client_secret' => 'R2ASaYsGXofHH9O6Tgo3SG55mFJh3CDconOjup0yAKqxN0qvIP',
            'redirect_uri' => 'http://framework.craduga.com/oauth/examples/index.php?provider=twitter',
        ]);
    }

    #############################################

    public function testInitFacebook()
    {
        $response = $this->_initFacebook($this->_initFacebookVo);

        $this->assertInstanceOf('\Biniweb\Oauth\Vo\OauthInitResponseVo', $response);
    }

    #############################################

    public function testInitGoogle()
    {
        $response = $this->_initGoogle($this->_initGoogleVo);

        $this->assertInstanceOf('\Biniweb\Oauth\Vo\OauthInitResponseVo', $response);
    }

    #############################################

    public function testParseInitTwitter()
    {
        $response = $this->_parseInitTwitter($this->_initTwitterVo);

        $this->assertArrayHasKey('access_token', $response);
    }

    #############################################

    public function testInitTwitter()
    {
        $response = $this->_initTwitter($this->_initTwitterVo);

        $this->assertInstanceOf('\Biniweb\Oauth\Vo\OauthInitResponseVo', $response);
    }

    #############################################

    protected function tearDown()
    {
        $this->_initFacebookVo = NULL;
        $this->_initGoogleVo = NULL;
        $this->_initTwitterVo = NULL;
    }

    #############################################
}