<?php
require_once('blocks.php');
require_once('fn_audio.php');

function out_page_audio()
{
  $meta = get_audio_meta($_GET['index']);
  if (!$meta) {
    http_response_code(404);
    return out_layout("Страница не найдена" . ' - ' . get_page_title(), "Страница не найдена", out_audio_list());
  }
  $page_title = $meta['title'] . ' - ' . get_page_title();
  return out_layout($page_title, out_audiofile($meta), out_audio_list());
}

print out_page_audio();
