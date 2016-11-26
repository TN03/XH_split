<?php

/**
 * Editorhook for internal filebrowser -> Codeeditor_XH
 *
 * @version $Id: script.php 270 2012-08-22 12:40:15Z cmb69 $
 */

$script = <<<EOS
<script type="text/javascript">
/* <![CDATA[ */
function setLink(url) {
    window.opener.codeeditor.insertURI(url);
    window.close();
}
/* ]]> */
</script>
EOS;

?>
