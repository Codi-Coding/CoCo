<?php
if (!defined('_GNUBOARD_')) exit;

// 스킨디렉토리를 SELECT 형식으로 얻음
function get_tmpl_skin_select($skin_gubun, $id, $name, $selected='', $event='')
{
    global $config;

    $skins = array();

    if(file_exists(G5_TMPL_SKIN_PATH.'/'.$skin_gubun)) {
        $dirs = get_skin_dir($skin_gubun, G5_TMPL_SKIN_PATH);
        if(!empty($dirs)) {
            foreach($dirs as $dir) {
                $skins[] = 'theme/'.$dir;
            }
        }
    }

    $skins = array_merge($skins, get_skin_dir($skin_gubun));

    $str = "<select id=\"$id\" name=\"$name\" $event>\n";
    for ($i=0; $i<count($skins); $i++) {
        if ($i == 0) $str .= "<option value=\"\">선택</option>";
        if(preg_match('#^theme/(.+)$#', $skins[$i], $match))
            $text = '(테마) '.$match[1];
        else
            $text = $skins[$i];

        $str .= option_selected($skins[$i], $selected, $text);
    }
    $str .= "</select>";
    return $str;
}

// 모바일 스킨디렉토리를 SELECT 형식으로 얻음
function get_mobile_tmpl_skin_select($skin_gubun, $id, $name, $selected='', $event='')
{
    global $config;

    $skins = array();

    if(defined('G5_USE_INTERNAL_MOBILE') && G5_USE_INTERNAL_MOBILE && file_exists(G5_TMPL_PATH.'/'.G5_MOBILE_DIR.'/index.php')) {
        if(file_exists(G5_TMPL_PATH.'/'.G5_MOBILE_DIR.'/'.G5_SKIN_DIR.'/'.$skin_gubun)) {
            $dirs = get_skin_dir($skin_gubun, G5_TMPL_PATH.'/'.G5_MOBILE_DIR.'/'.G5_SKIN_DIR);
            if(!empty($dirs)) {
                foreach($dirs as $dir) {
                    $skins[] = 'theme/'.$dir;
                }
            }
        }
    } else if(file_exists(G5_MOBILE_TMPL_SKIN_PATH.'/'.$skin_gubun)) {
        $dirs = get_skin_dir($skin_gubun, G5_MOBILE_TMPL_SKIN_PATH);
        if(!empty($dirs)) {
            foreach($dirs as $dir) {
                $skins[] = 'theme/'.$dir;
            }
        }
    }

    $skins = array_merge($skins, get_skin_dir($skin_gubun, G5_MOBILE_PATH.'/'.G5_SKIN_DIR));

    $str = "<select id=\"$id\" name=\"$name\" $event>\n";
    for ($i=0; $i<count($skins); $i++) {
        if ($i == 0) $str .= "<option value=\"\">선택</option>";
        if(preg_match('#^theme/(.+)$#', $skins[$i], $match))
            $text = '(테마) '.$match[1];
        else
            $text = $skins[$i];

        $str .= option_selected($skins[$i], $selected, $text);
    }
    $str .= "</select>";
    return $str;
}

?>
