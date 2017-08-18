<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
use \yii\web\Request;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'thumbnail'],
    'controllerNamespace' => 'frontend\controllers',
    'language'  => 'en',
    'sourceLanguage' => 'en-US',
    'modules' => [
        'job' => [
            'class'             => 'frontend\modules\job\Module',      
                'on Job'        => ['frontend\event\Notification','handler'],
                'on Applied'    => ['frontend\event\Notification','handler'],
                'on Favorite'   => ['frontend\event\Notification','handler'],
                'on Saved'      => ['frontend\event\Notification','handler'],      	 
                  ],
        'user' => [
            'class' => 'frontend\modules\user\Module',
            'on Payment'    => ['frontend\event\Notification','handler'],
            'on Applied'    => ['frontend\event\Notification','handler'],
            'on Send'    => ['frontend\event\Notification','handler'],
        ],
        'cms' => [
                    'class' => 'frontend\modules\cms\Module',
                ],

    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'identityCookie' => [
                'name' => '_frontendUser', // unique for frontend
                'path'=>'/frontend/web',
            ],
        ],

        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                /*'twitter' => [
                    'class' => 'yii\authclient\clients\Twitter',
                    'consumerKey' => ' lh4mQWZCC6KMIkHeAsWb4Mz6i',
                    'consumerSecret' => ' QNNwK97WldERCjcEmw7pIC76YuuoWkOBWvdY85PlQv7KaTB4QY',
                ],*/
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '1858821357666641',
                    'clientSecret' => '40f713d410a14faf0ae92aa4f367d959',
                    'attributeNames' => ['name', 'email', 'first_name', 'last_name'],
                ],
                // etc.
            ],
        ],
        // ...
        'session' => [
            'name' => '_frontendPHPBACKSESSID',
            'savePath' => __DIR__ . '/../runtime',
        ],

        'request' => [
            'baseUrl' => $baseUrl,
            'cookieValidationKey' => 'ey6xob0W0u9VYImBCsui-rMJxDBDHSuz',
            'csrfParam' => '_frontendCSRF',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@frontend/views/rolecall'
                ]
                
            ]
        ], 
        'i18n' => [
            'translations' => [
                'job' => [  
                    'class' => 'yii\i18n\PhpMessageSource', 
                    'sourceLanguage' =>  'en',
                    'basePath' => '@frontend/messages',
                ],
            ],
        ],

        'urlManager' => [
            'baseUrl' => $baseUrl,
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => [
                'contact'   => 'site/contact',
                'login'     => 'site/login',
                'logout'     => 'site/logout',
                'signup'    => 'site/signup',
                'dashboard'    => 'site/dashboard',
                'request-password-reset'    => 'site/request-password-reset',
                'become-job-owner'    => 'site/become-job-owner',
                'change-password'  => 'site/change-password',

                'job-fields'  => 'site/user-custome-fields',
                'user-fields'  => 'site/job-custome-fields',

                'update'  => 'user/user/update',
                'rolecalls'  => 'job/job-item',
                'payment'    => 'site/payment',
                'execute-agreement'    => 'user/user/execute-agreement',

                'policy'  => 'site/policy',
                'terms'  => 'site/terms',
                'talent'  => 'site/talent',
                'director'  => 'site/director',

                'ads'  => 'user/user-ads',

                /* Start Messaging Section */
                'messages' => 'user/user-msg/index',
                'message' => 'user/user-msg/message',
                'message-send' => 'user/user-msg/create',
                'download-attachment' => 'user/user-msg/download-attachment',
                'messenger' => 'user/user-msg/message',
                'msg-validate' => 'user/user-msg/validate',
                'attachment-upload' => 'user/user-msg/attachment-upload',
                'append-recent' => 'user/user-msg/append-recent',
                'append-attachment' => 'user/user-msg/append-attachment',

                /* End Messaging Section */

                'my-jobs'  => '/job/job-item/my-jobs',
                'job-talents'  => '/user/user/job-talents',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<slug:[a-z0-9-]+>' => 'cms/cms-item/view',

            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
    ],	 
    'params' => $params,
    'as access' => [
        'class' => 'backend\modules\auth\components\AccessControl',
        'allowActions' => [
            'site/*',
            'cms/*',
            'user/user-director-msg/*',
            'site/dashboard',
            'job/default/index',
            'job/job-item/index',
            'job/job-item/view',
           /* 'job/job-item/talent-status',*/
            'user/user-director-msg',
            'user/user-director',
            'user/user-director/index',
            'user/user-director/director',
            'user/user-subscriber/validation',
            'user/user-subscriber/create'
        ]
    ]
   
];