<?php
header('Content-Type: text/plain');
echo 'max_input_vars=' . ini_get('max_input_vars') . PHP_EOL;
echo 'sapi=' . php_sapi() . PHP_EOL;
echo 'post_max_size=' . ini_get('post_max_size') . PHP_EOL;
echo 'post_count=' . count($_POST) . PHP_EOL;