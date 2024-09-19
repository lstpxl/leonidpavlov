<?php

function mb_str_replace($haystack, $search, $replace, $offset = 0, $encoding = "UTF-8")
{
  $len_sch = mb_strlen($search, $encoding);
  $len_rep = mb_strlen($replace, $encoding);

  while (($offset = mb_strpos($haystack, $search, $offset, $encoding)) !== false) {
    $haystack = mb_substr($haystack, 0, $offset, $encoding)
      . $replace
      . mb_substr($haystack, $offset + $len_sch, 1000, $encoding);
    $offset = $offset + $len_rep;
    if ($offset > mb_strlen($haystack, $encoding)) break;
  }
  return $haystack;
}


function cmp_title($a, $b)
{
  if ($a['title'] > $b['title']) return 1;
  if ($a['title'] < $b['title']) return -1;
  return 0;
}
