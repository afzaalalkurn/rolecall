 <?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
use \yii\web\Request;

$baseUrl = str_replace('/backend/web', '/admin', (new Request)->getBaseUrl());
return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'thumbnail'],
    'language'	=> 'en_US',
    'modules' => [ 
        'auth'		=>  [
            'class' => 'backend\modules\auth\Module',
            //'layout' => 'top-menu',
            'layout' => '@backend/views/layouts/top-menu',
            'mainLayout' => '@backend/views/layouts/main.php',
        
            'menus' => [
                // change label
                'assignment' => [ 'label' => 'Grant Access' ],
                /* 'route' => null, // disable menu */
            ],
        
        ],
        'core' => [
            'class' => 'backend\modules\core\Module',
            'layout' => '@backend/views/layouts/top-menu',
            'mainLayout' => '@backend/views/layouts/main.php',
        ],
       
        'cms' 		=> 	[
            'class' => 'backend\modules\cms\Module',
            //'layout' => 'top-menu',
            'layout' => '@backend/views/layouts/top-menu',
            'mainLayout' => '@backend/views/layouts/main.php',
        ],
        'user'		=>  [
            'class' 	=> 'backend\modules\user\Module',
            //'layout' 	=> 'top-menu',
            'layout' => '@backend/views/layouts/top-menu',
            'mainLayout' => '@backend/views/layouts/main.php',
        ],
        'job'		=>  [
            'class' 	=> 'backend\modules\job\Module',
            //'layout' 	=> 'top-menu',
            'layout' => '@backend/views/layouts/top-menu',
            'mainLayout' => '@backend/views/layouts/main.php',
        ],
		
        'membership' => [
            'class' => 'backend\modules\membership\Module',
			//'layout' => '@backend/views/layouts/top-menu',
            //'mainLayout' => '@backend/views/layouts/main.php',
        ],

        
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'identityCookie' => [
                'name' => '_backendUser', // unique for backend
                'path'=>'/backend/web',
            ]
        ],
        'session' => [
            'name' => '_backendPHPBACKSESSID',
            'savePath' => __DIR__ . '/../runtime',
        ],
        'request' => [
            'baseUrl' => $baseUrl,
            'cookieValidationKey' => 'fpp0cY5DCk5Ssiqgd9yiizVQ4xsRoLVQ',
            'csrfParam' => '_backendCSRF',
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
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'baseUrl' => $baseUrl,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'authManager' => [ 'class' => 'yii\rbac\DbManager', ],
    ],
    'params' => $params,
    'as access' => [
        'class' => 'backend\modules\auth\components\AccessControl',
        'allowActions' => []
    ],
];
