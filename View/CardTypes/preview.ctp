<?php
if (isset($message)) {
    echo "<p>".$message."</p>";
}
if (isset($image_path)) {
    echo "<img id=\"cardPreviewImg\" src=\"" . $this->webroot . $image_path . "\">";
}