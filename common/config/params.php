<?php
return [
    require_once(__DIR__ . '/../../common/config/functions.php'),
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@setyes.com',
    'user.passwordResetTokenExpire' => 3600,
    'secretKeyExpire' => 60 * 60,                       // время хранения ключа
    'emailActivation' => true,                          // активация через емайл
];
