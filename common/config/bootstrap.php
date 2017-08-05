<?php
Yii::setAlias('@app',   'common');
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@uploads', dirname(dirname(__DIR__)) . '/uploads');
Yii::setAlias('@cache', dirname(dirname(__DIR__)) . '/uploads/cache');
Yii::setAlias('@image',   '/uploads/cache');