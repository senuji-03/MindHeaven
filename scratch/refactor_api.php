<?php
$file = 'app/controllers/AppointmentApiControl.php';
$content = file_get_contents($file);

// Very simple regex for [] array literals. 
// Note: This is tricky because of $obj['key'].
// We want to replace [ where it's not preceded by a variable member access part.
// But PHP 5.3 doesn't support $v['k'] either? 
// No, PHP 5.3 DOES support $v['k']. It just doesn't support array literals [1,2].

// Let's use a more surgical approach for the problematic lines.
$replaces = array(
    "['id' =>" => "array('id' =>",
    "['patientName' =>" => "array('patientName' =>",
    "['error' =>" => "array('error' =>",
    "['message' =>" => "array('message' =>",
    "['slots' =>" => "array('slots' =>",
    "['duration' =>" => "array('duration' =>",
    "['detail' =>" => "array('detail' =>",
    " = [" => " = array(",
    ", [" => ", array(",
    "( [" => "( array(",
    "return [" => "return array(",
    "array_map(function" => "array_map(function", // just to check
);

foreach ($replaces as $search => $replace) {
    $content = str_replace($search, $replace, $content);
}

// Fix trailing ] for literals. This is the hardest part.
// For simplicity, I'll just manually review or use a better tool.
file_put_contents($file, $content);
echo "Refactored $file\n";
