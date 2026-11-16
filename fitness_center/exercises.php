<?php
$array = array( 'key1' => 'value1', 'key2'
=> 'value2', 'key3' => 'value3');
extract($array);
echo "$key1";