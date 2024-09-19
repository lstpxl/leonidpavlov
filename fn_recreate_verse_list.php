<?php


// For initial file creation
function make_verse_list_json()
{
  $list = get_verse_list();
  for ($i = 0; $i < sizeof($list); $i++) {
    $list[$i] = [
      'index' => intval($list[$i]["index"]),
      'title' => get_verse_title($list[$i]["fullfilename"]),
    ];
  }
  usort($list, "cmp_title");
  if ($handle = fopen(get_verse_dir() . '/verse_list.json', 'a')) {
    fwrite($handle, json_encode($list, JSON_UNESCAPED_UNICODE));
    fclose($handle);
  }
}
