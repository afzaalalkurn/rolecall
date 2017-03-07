<?php
require(__DIR__ . '/functions.php');

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            /*'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'ganesh.alkurn@gmail.com',
                'password' => 'project@123',
                'port' => '587',
                'encryption' => 'tls',
            ],*/
        ],
        'thumbnail' => [
            'class' => 'himiklab\thumbnail\EasyThumbnail',
            'cacheAlias'    => Yii::getAlias('@cache/'),
            'uploadsAlias'  => Yii::getAlias('@uploads/'),
            'imageAlias'    => Yii::getAlias('@image/'),
            'defaultImage'  => 'default.png',
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\recaptcha\ReCaptcha',
            'siteKey' => '6Lf2qwcUAAAAAPvcvuKqEAzeEcMe7Rd7dOD3bS3r',
            'secret' =>  '6Lf2qwcUAAAAAMdB5jZPNQdiXo_7BNNZXMTH0qZW',

            /*'siteKey' => '6LfDIQgUAAAAAOB3-cc4q9xwFyxIaW9PoE8LFA6P',
            'secret' =>  '6LfDIQgUAAAAAM_wn8XM-J8BGQ_S7bVnhiEcJ2lg',*/
        ],
        'paypal'=> [
            'class'        =>  Yii::getAlias('@app') . '\components\Paypal',
            'clientId'     => 'ATzmjUkutlWc3iJQbdbmCiR1O8k7ZThTTsGBBFHxwTcoImHsGseBTV0Vu-ZIckObhLD3jWka9jh75gyd',
            'clientSecret' => 'EA69fQ3oT0fle87L1AqIpoOlZwugadDvOqChdqcIv0-eSsJtTV4-nqX5WiTr3Q7DPY1Bpl4gn3wjbsH5',
            'mode'         => 'sandbox',
            'currency'     => 'USD',
            'businessEmail'=> 'ganesh@alkurn.info',
        ],
        'stripe' => [
            'class' => 'ruskid\stripe\Stripe',
            'publicKey' => "pk_test_jFzYT5fynCopeUVXWtKYC0l6",
            'privateKey' => "sk_test_4sEbGo83tvc8tgtEd56NbB72",
        ],
    ],
    'bootstrap' => [
        [
            'class' => 'common\components\LanguageSelector',
            'supportedLanguages' => ['en_US'],
        ],
    ],
];

