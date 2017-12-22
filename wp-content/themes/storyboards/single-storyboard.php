<?php
header("HTTP/1.1 301 Moved Permanently");
header("Location: " . get_site_url());
exit();
