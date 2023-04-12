<?php 

return [
  'projectName' => env('PROJECT_NAME', 'FiMM Registration System'),
  'id' => env('MODULE_ID', 0),
  'name' => env('MODULE_NAME', ''),
  'desc' => env('MODULE_DESC', ''),
  'version' => env('MODULE_VERSION', '1.0.0'),
  'title' => env('MODULE_DOC_NAME', ''),
  'email' => env('DEV_EMAIL', 'araken@vn.my'),
  'host' => env('MODULE_HOST', 'localhost'),
  'basePath' => env('MODULE_PATH', '/api/module0'),
  'moduleJSON' => env('MODULE_API_DOC', 'module0.json'),
  'port' => env('DEFAULT_PORT', '7000')
];