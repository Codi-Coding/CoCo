<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

define('G5_SLACK_DIR', 'slack');

if(is_file(G5_PLUGIN_PATH.'/'.G5_SLACK_DIR.'/config.php'))
    include_once(G5_PLUGIN_PATH.'/'.G5_SLACK_DIR.'/config.php');