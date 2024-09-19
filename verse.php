<?php
require_once('blocks.php');
require_once('fn_verse.php');

function out_page_verse()
{
  $verse_meta = get_verse_meta($_GET['index']);
  if (!$verse_meta) {
    http_response_code(404);
    return out_layout("Страница не найдена" . ' - ' . get_page_title(), "Страница не найдена", out_verse_list());
  }
  $page_title = get_verse_title($verse_meta['fullfilename']) . ' - ' . get_page_title();
  return out_layout($page_title, out_verse($verse_meta['index']), out_verse_list());
}

print out_page_verse();
