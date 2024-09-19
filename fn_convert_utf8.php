<?php
require_once('fn_global.php');
require_once('fn_basic.php');

function convert_verse_to_utf8($input_filepath, $output_filepath)
{
  $contents = false;
  if ($handle = fopen($input_filepath, "r")) {
    $contents = fread($handle, filesize($input_filepath));
    if (!$contents) {
      var_dump("Failed fread " . $input_filepath);
      return false;
    }
  } else {
    var_dump("Failed fopen " . $input_filepath);
  }
  $utf8_contents = mb_convert_encoding($contents, 'UTF-8', 'Windows-1251');
  if ($handle = fopen($output_filepath, 'a')) {
    if (!fwrite($handle, $utf8_contents)) {
      var_dump("Failed fwrite " . $output_filepath);
    }
    fclose($handle);
  } else {
    var_dump("Failed fopen " . $output_filepath);
  }
}

function mass_convert_verses_to_utf8()
{
  $list = get_verse_list();
  foreach ($list as &$item) {
    $input_filename = get_verse_dir() . "/" . get_verse_filename($item["index"]);
    $output_filename = get_verse_dir_utf8() . "/" . get_verse_filename($item["index"]);
    convert_verse_to_utf8($input_filename, $output_filename);
  }
}
