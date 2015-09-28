<?php

return array(
    'from'      => 'system-notice@rakuichi-rakuza.jp',
    'from_name' => 'rakuichi system',
    'email'     => array('rakuichi-test@aucfan.com'),
    'subject'   => '【楽市楽座】System Error',
    'body'      => <<<'EOT'
以下のエラーが発生しました。ご確認下さい。
--
エラーコード:
##error_message## (##error_code##)

ファイル名:
##file## :##line##

URL:
##url##

INPUT:
##input##

日時:
##occurred_at##

IPアドレス:
##real_ip##

User Agent:
##user_agent##

ユーザID:
##user_id##
EOT
);
