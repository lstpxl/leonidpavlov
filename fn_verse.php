<?php
require_once('fn_global.php');
require_once('fn_basic.php');
require_once('fn_convert_utf8.php');

function get_padded_index($index)
{
  return str_pad(intval($index), 5, "0", STR_PAD_LEFT);
}

function get_verse_filename($index)
{
  return get_padded_index($index) . ".txt";
}

function out_verse_list()
{
  $list = get_verse_list();
  $out = '<h3>все стихи:</h3>' .
    '<ol>';
  foreach ($list as &$item) {
    $out .= '<li><a href="verse.php?index=' . get_padded_index($item["index"]) . '">' . $item["title"] . '</a></li>';
  }
  $out .= '</ol>';
  return $out;
}


function get_verse_list()
{
  $dir = get_verse_dir();
  $list = get_verse_list_from_json();
  foreach ($list as &$item) {
    $item["filename"] = get_verse_filename($item["index"]);
    $item["fullfilename"] = $dir . "/" . $item["filename"];
  }
  return $list;
  // $list = make_verse_list_from_dir();
}


function make_verse_list_from_dir()
{
  $dir = get_verse_dir();
  $list = [];
  $dh = opendir($dir);
  $i = 1;
  while (($file = readdir($dh)) !== false) {
    if ($file != "." && $file != "..") {
      if (substr($file, -4, 4) == ".txt") {
        $number = substr($file, 0, -4);
        $ok = true;
        for ($c = 0; $c < strlen($number); $c++) {
          $isd = ctype_digit($number[$c]);
          if (!$isd) $ok = false;
        }
        if ($ok) {
          $item = array();
          $item["index"] = $number;
          $item["filename"] = $file;
          $item["fullfilename"] = $dir . "/" . $file;
          $list[] = $item;
        }
      }
      $i++;
    }
  }
  closedir($dh);
  return $list;
}


function get_verse_list_from_json()
{
  $filename = get_verse_list_dir() . "/verse_list.json";
  if ($handle = fopen($filename, "r")) {
    $contents = fread($handle, filesize($filename));
    if ($contents) {
      $list = json_decode($contents, null, 3, JSON_OBJECT_AS_ARRAY);
      if ($list) {
        return $list;
      } else {
        var_dump("Failed json_decode " . json_last_error());
      }
    } else {
      var_dump("Failed fread " . $filename);
    }
  } else {
    var_dump("Failed fopen " . $filename);
  }
  return false;
}


function get_has_title($filename)
{

  mb_internal_encoding('UTF-8');

  $handle = fopen($filename, "rb");
  $contents = fread($handle, filesize($filename));
  fclose($handle);

  $contents = mb_convert_encoding($contents, "UTF-8", "Windows-1251");


  $crlf = "\x0A";
  $lines = explode($crlf, $contents);

  $titletag = "TITLE";
  $title = "";
  $firstline = "";
  for ($l = 0; $l < sizeof($lines); $l++) {
    if (mb_substr($lines[$l], 0, 1) == "#") {
      if (mb_substr($lines[$l], 1, mb_strlen($titletag)) == $titletag) {
        $title = mb_substr($lines[$l], 7);
      }
    } else {
      if (mb_strlen($firstline) == 0) if (mb_strlen($lines[$l]) > 0) {
        $firstline = $lines[$l];
      }
    }
  }

  if (mb_strlen($title) > 0) return true;

  return false;
}



function get_verse_title($filename)
{

  mb_internal_encoding('UTF-8');

  $handle = fopen($filename, "rb");
  $contents = fread($handle, filesize($filename));
  fclose($handle);

  $contents = mb_convert_encoding($contents, "UTF-8", "Windows-1251");


  $crlf = "\x0A";
  $lines = explode($crlf, $contents);

  //print "<p>".bin2hex($contents[0])."</p>";

  $titletag = "TITLE";
  $footertag = "FOOTER";
  $title = "";
  $firstline = "";
  for ($l = 0; $l < sizeof($lines); $l++) {

    if (mb_substr($lines[$l], 0, 1) == "#") {
      if (mb_substr($lines[$l], 1, mb_strlen($titletag)) == $titletag) {
        $title = mb_substr($lines[$l], 7);
      }
    } else {
      if (mb_strlen($firstline) == 0) if (mb_strlen($lines[$l]) > 1) {
        $firstline = $lines[$l];
      }
    }
  }

  if (mb_strlen($title) > 0) return $title;
  if (mb_strlen($firstline) > 0) {
    if (mb_strlen($firstline) > 0) if ($firstline[0] == '-')
      $firstline = mb_substr($firstline, 1, 1000);
    if (mb_strlen($firstline) > 0) if ($firstline[0] == ' ')
      $firstline = mb_substr($firstline, 1, 1000);
    return $firstline . "...";
  }

  return false;
}


function read_verse_utf8($filepath)
{
  if ($handle = fopen($filepath, "r")) {
    if ($contents = fread($handle, filesize($filepath))) {
      // ok 
      return $contents;
    } else {
      var_dump("Failed fread " . $filepath);
      return false;
    }
  } else {
    var_dump("Failed fopen " . $filepath);
    return false;
  }
}

function out_verse($index)
{
  return out_verse_new($index);
}

function get_tags()
{
  return [
    '' => ['tag' => 'p', 'class' => ''],
    'TITLE' => ['tag' => 'h1', 'class' => ''],
    'DATE' => ['tag' => 'p', 'class' => 'date'],
    'COMMENT' => ['tag' => 'p', 'class' => 'comment'],
    'AUTHORCOMMENT' => ['tag' => 'p', 'class' => 'authorcomment'],
    'FOOTER' => ['tag' => 'p', 'class' => 'footer'],
    'HIDE' => ['tag' => 'p', 'class' => 'hidden'],
    'BOOK' => ['tag' => 'p', 'class' => 'hidden'],
  ];
}

function parse_line($line)
{
  $line = trim($line);
  $tokens = explode(" ", $line, 2);
  $token = $tokens[0];
  if (mb_substr($token, 0, 1) === "#") {
    $tag = mb_substr($token, 1, NULL);
    return ['tag' => $tag, 'content' => isset($tokens[1]) ? $tokens[1] : ""];
  } else {
    return ['tag' => '', 'content' => $line];
  }
}

function out_verse_new($index)
{
  $filepath = get_verse_dir_utf8() . "/" . get_verse_filename($index);
  if (!$raw = read_verse_utf8($filepath)) {
    var_dump("Failed read_verse_utf8 " . $filepath);
    return false;
  }
  $lines = explode(PHP_EOL, $raw);
  $tags = get_tags();
  $out = '';
  $out .= '<article class="verse">';
  foreach ($lines as &$line) {
    $line = trim($line);
    if ($line !== '' || $out !== '') {
      $parsed = parse_line($line);
      if (isset($tags[$parsed['tag']])) {
        $item = $tags[$parsed['tag']];
        $out .= '<' . $item['tag'] . ($item['class'] != '' ? ' class="' . $item['class'] . '"' : '') . '>' . $parsed['content'] . '</' . $item['tag'] . '>' . PHP_EOL;
      }
    }
  }
  $out .= '</article>';
  return $out;
}

function out_verse_old($filename)
{

  mb_internal_encoding('UTF-8');

  $handle = fopen($filename, 'rb');
  $contents = fread($handle, filesize($filename));
  fclose($handle);

  $contents = mb_convert_encoding($contents, 'UTF-8', 'Windows-1251');

  $crlf = chr(10);
  $lines = explode($crlf, $contents);

  $out = '';


  $tags = get_tags();

  if (!get_has_title($filename)) {
    //$out .= $tags['TITLE']['prefix'].'* * *'.$tags['TITLE']['suffix'].PHP_EOL;
    $out .= '<div style="padding-top: 20px;"></div>';
  }

  for ($l = 0; $l < sizeof($lines); $l++) {
    $lines[$l] = mb_str_replace($lines[$l], chr(13), '', 0, "UTF-8");
    $lines[$l] = mb_str_replace($lines[$l], '\x0A', '', 0, "UTF-8");
    /*
    if (mb_substr($lines[$l], (mb_strlen($tag) - 1), 1) == "\r") {
      $lines[$l] = mb_substr($lines[$l], 0, (mb_strlen($tag) - 1));
    }
    if (mb_substr($lines[$l], (mb_strlen($tag) - 1), 1) == "\n") {
      $lines[$l] = mb_substr($lines[$l], 0, (mb_strlen($tag) - 1));
    }
    */
    if (mb_substr($lines[$l], 0, 1) == "#") {
      $tag = mb_strstr(mb_substr($lines[$l], 1, 20), ' ', true);
      if (isset($tags[$tag])) {
        $print = true;
        $decor = $tags[$tag];
        $content = mb_substr($lines[$l], (mb_strlen($tag) + 2));
      } else {
        $print = false;
      }
    } else {
      $print = true;
      $decor = $tags[""];
      if (mb_strlen($lines[$l], 'UTF-8') < 1) {
        $print = false;
        $content = '';
      } else {
        $content = $lines[$l];
      }
    }
    if ($print) $out .= $decor['prefix'] . $content . $decor['suffix'];
    if ($print) if (isset($lines[$l + 1])) if (mb_strlen($lines[$l + 1]) < 2) {
      $out .= '<div style="padding-top: 20px;"></div>';
    }
    if ($print) $out .= PHP_EOL;
  }

  return $out;
}


function get_verse_meta($index)
{
  $is_index_valid = true;
  if (!isset($index)) $is_index_valid = false;
  if (!is_numeric($index)) $is_index_valid = false;
  $index = intval($index);
  if ($index < 1) $is_index_valid = false;
  if (!$is_index_valid) return false;

  $list = get_verse_list();
  for ($i = 0; $i < sizeof($list); $i++) {
    if ($index == $list[$i]['index']) {
      return $list[$i];
    }
  }
  return false;
}
