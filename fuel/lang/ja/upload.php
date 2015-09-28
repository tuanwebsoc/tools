<?php

return array(
	'error_'.\Upload::UPLOAD_ERR_OK						=> 'ファイルのアップロードが完了しました',//'The file uploaded with success',
	'error_'.\Upload::UPLOAD_ERR_INI_SIZE				=> 'フアップロードされたファイルは php.ini から指示された upload_max_filesize を超えます',//'The uploaded file exceeds the upload_max_filesize directive in php.ini',
	'error_'.\Upload::UPLOAD_ERR_FORM_SIZE				=> 'フアップロードされたファイルは HTML form から明示された MAX_FILE_SIZE を超えます',//'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
	'error_'.\Upload::UPLOAD_ERR_PARTIAL				=> 'フアップロードされたファイルは一部分がアップロードされました',//'The uploaded file was only partially uploaded',
	'error_'.\Upload::UPLOAD_ERR_NO_FILE				=> 'ファイルはアップロードされませんでした',//'No file was uploaded',
	'error_'.\Upload::UPLOAD_ERR_NO_TMP_DIR				=> '一時的に設定されたアップロードのフォルダーが見つかりませんでした',//'Configured temporary upload folder is missing',
	'error_'.\Upload::UPLOAD_ERR_CANT_WRITE				=> 'アップロードされたファイルをディスクへ書き込むのが失敗しました',//'Failed to write uploaded file to disk',
	'error_'.\Upload::UPLOAD_ERR_EXTENSION				=> 'インストールされた PHP 拡張でアップロードがブロックされました',//'Upload blocked by an installed PHP extension',
	'error_'.\Upload::UPLOAD_ERR_MAX_SIZE				=> 'アップロードされたファイルは定義された最大のサイズを超えます',//'The uploaded file exceeds the defined maximum size',
	'error_'.\Upload::UPLOAD_ERR_EXT_BLACKLISTED		=> '拡張のファイルのアップロードは許可されていません',//'Upload of files with this extension is not allowed',
	'error_'.\Upload::UPLOAD_ERR_EXT_NOT_WHITELISTED	=> '拡張のファイルのアップロードは許可されていません',//'Upload of files with this extension is not allowed',
	'error_'.\Upload::UPLOAD_ERR_TYPE_BLACKLISTED		=> '拡張のファイルのアップロードは許可されていません',//'Upload of files of this file type is not allowed',
	'error_'.\Upload::UPLOAD_ERR_TYPE_NOT_WHITELISTED	=> 'このファイルの様式のアップロードは許可されていません',//'Upload of files of this file type is not allowed',
	'error_'.\Upload::UPLOAD_ERR_MIME_BLACKLISTED		=> 'このファイルの mime 様式のアップロードは許可されていません',//'Upload of files of this mime type is not allowed',
	'error_'.\Upload::UPLOAD_ERR_MIME_NOT_WHITELISTED	=> 'このファイルの mime 様式のアップロードは許可されていません',//'Upload of files of this mime type is not allowed',
	'error_'.\Upload::UPLOAD_ERR_MAX_FILENAME_LENGTH	=> 'アップロードされたファイルの名前は定義された最大の長さを超えます',//'The uploaded file name exceeds the defined maximum length',
	'error_'.\Upload::UPLOAD_ERR_MOVE_FAILED			=> 'アップロードされたファイルは　it\'s final destination　へ移動できません',//'Unable to move the uploaded file to it\'s final destination',
	'error_'.\Upload::UPLOAD_ERR_DUPLICATE_FILE 		=> 'アップロードされたファイルの名前は存在しています',//'A file with the name of the uploaded file already exists',
	'error_'.\Upload::UPLOAD_ERR_MKDIR_FAILED			=> 'file\'s destination directory　が作成できません',//'Unable to create the file\'s destination directory',
);
