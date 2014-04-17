<?php

require_once __DIR__ . '/../vendor/autoload.php';

if (isset($_GET['provider']) && isset($_GET['code'])) {
    switch ($_GET['provider']) {
        case \Biniweb\Oauth\Constants\OauthFacebookConstant::PROVIDER_NAME:
            $requestVo = new \Biniweb\Oauth\Vo\OauthCallbackRequestVo([
                'provider' => $_GET['provider'],
                'client_id' => '300263943457782',
                'client_secret' => '59730437e6b859da5543fed1acfb90ea',
                'redirect_uri' => 'http://framework.craduga.com/oauth/examples/index.php?provider=' . $_GET['provider'],
                'code' => $_GET['code'],
            ]);
            $responseVo = Biniweb\Oauth\Oauth::getInstance()->callback($requestVo);
            break;
        case \Biniweb\Oauth\Constants\OauthGoogleConstant::PROVIDER_NAME:
            $requestVo = new \Biniweb\Oauth\Vo\OauthCallbackRequestVo([
                'provider' => $_GET['provider'],
                'client_id' => '796040485246.apps.googleusercontent.com',
                'client_secret' => 'mruzzXtxJsG1HPRaLZei9kUT',
                'redirect_uri' => 'http://framework.craduga.com/oauth/examples/index.php?provider=' . $_GET['provider'],
                'code' => $_GET['code'],
            ]);
            $responseVo = Biniweb\Oauth\Oauth::getInstance()->callback($requestVo);
            break;
        default:
            $responseVo = NULL;
    }
} elseif (isset($_GET['provider']) && isset($_GET['access_token'])) {
    $requestVo = new \Biniweb\Oauth\Vo\OauthCallbackRequestVo([
        'provider' => $_GET['provider'],
        'client_id' => 'HrO0irPBb4rUm3nmuLOp41lwQ',
        'client_secret' => 'R2ASaYsGXofHH9O6Tgo3SG55mFJh3CDconOjup0yAKqxN0qvIP',
        'redirect_uri' => 'http://framework.craduga.com/oauth/examples/index.php?provider=' . $_GET['provider'],
        'code' => $_GET['access_token'],
    ]);
    $responseVo = Biniweb\Oauth\Oauth::getInstance()->callback($requestVo);
} else {
    $responseVoMany = \Biniweb\Oauth\Oauth::getInstance()->init([
        new \Biniweb\Oauth\Vo\OauthInitRequestVo([
            'provider' => \Biniweb\Oauth\Constants\OauthFacebookConstant::PROVIDER_NAME,
            'client_id' => '300263943457782',
            'client_secret' => '59730437e6b859da5543fed1acfb90ea',
            'redirect_uri' => 'http://framework.craduga.com/oauth/examples/index.php?provider=facebook',
        ]),
        new \Biniweb\Oauth\Vo\OauthInitRequestVo([
            'provider' => \Biniweb\Oauth\Constants\OauthGoogleConstant::PROVIDER_NAME,
            'client_id' => '796040485246.apps.googleusercontent.com',
            'client_secret' => 'mruzzXtxJsG1HPRaLZei9kUT',
            'redirect_uri' => 'http://framework.craduga.com/oauth/examples/index.php?provider=google',
        ]),
        new \Biniweb\Oauth\Vo\OauthInitRequestVo([
            'provider' => \Biniweb\Oauth\Constants\OauthTwitterConstant::PROVIDER_NAME,
            'client_id' => 'HrO0irPBb4rUm3nmuLOp41lwQ',
            'client_secret' => 'R2ASaYsGXofHH9O6Tgo3SG55mFJh3CDconOjup0yAKqxN0qvIP',
            'redirect_uri' => 'http://framework.craduga.com/oauth/examples/index.php?provider=twitter',
        ]),
    ]);
}
?>

<html>
<head>
    <title>Oauth example</title>
</head>
<body>
<div>
    <?php if (isset($responseVoMany)) : ?>
        <?php foreach ($responseVoMany as $vo) : ?>
            <p>
                <a id="<?php echo $vo->getProvider(); ?>" href="<?php echo $vo->getLoginUrl(); ?>">
                    <?php echo $vo->getProvider(); ?>
                </a>
            </p>
        <?php endforeach; ?>
    <?php elseif (isset($responseVo)) : ?>
        <p>Email: <?php echo $responseVo->getEmail(); ?></p>
        <p>ID: <?php echo $responseVo->getId(); ?></p>
    <?php
    else : ?>
        <p>Error connecting to: <?php echo $_GET['provider']; ?></p>
    <?php endif; ?>
</div>
</body>
</html>