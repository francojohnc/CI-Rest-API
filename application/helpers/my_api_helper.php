<?php

function remove_unknown_field($raw_data,$expected_fields) {
    $new_data = array();
    foreach ($raw_data as $field_name=>$field_values) {
        if ($field_values != '' && in_array($field_name,array_values($expected_fields))){
            $new_data([$field_name])=$field_values;
        }
    }
    return $new_data;
}

?>
