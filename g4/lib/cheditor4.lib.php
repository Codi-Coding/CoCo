<?
if (!defined('_GNUBOARD_')) exit;

if ($g5['is_cheditor5']) 
{
    $g5['cheditor4']      = "cheditor5";
    $g5['cheditor4_url'] = $g5['url'] . "/" . $g5['cheditor4'];

    function cheditor1($id, $width='100%', $height='250')
    {
        global $g5;

        return "
        <script type='text/javascript'>
        var ed_{$id} = new cheditor('ed_{$id}');
        ed_{$id}.config.editorHeight = '{$height}';
        ed_{$id}.config.editorWidth = '{$width}';
        ed_{$id}.inputForm = 'tx_{$id}';
        </script>";
    }
}
else 
{
    function cheditor1($id, $width='100%', $height='250')
    {
        global $g5;

        return "
        <script type='text/javascript'>
        var ed_{$id} = new cheditor('ed_{$id}');
        ed_{$id}.config.editorHeight = '{$height}';
        ed_{$id}.config.editorWidth = '{$width}';
        ed_{$id}.config.imgReSize = false;
        ed_{$id}.config.fullHTMLSource = false;
        ed_{$id}.config.editorPath = '{$g5[cheditor4_url]}';
        ed_{$id}.inputForm = 'tx_{$id}';
        </script>";
    }
}

function cheditor2($id, $content='')
{
    global $g5;

    return "
    <textarea name='{$id}' id='tx_{$id}' style='display:none;'>{$content}</textarea>
    <script type='text/javascript'>
    ed_{$id}.run();
    </script>";
}
 
function cheditor3($id)
{
    return "document.getElementById('tx_{$id}').value = ed_{$id}.outputBodyHTML();";
}
?>
