<?php
require_once('fn_basic.php');
require_once('fn_global.php');

function get_audio_list()
{
  $list = array();
  $list[] = array('file' => 'c1s1_01', 'title' => 'Письмо сыну');
  $list[] = array('file' => 'c1s1_02', 'title' => 'Отзвенела твоя гитара');
  $list[] = array('file' => 'c1s1_03', 'title' => 'Современнику');
  $list[] = array('file' => 'c1s1_04', 'title' => 'Звезды кремля');
  $list[] = array('file' => 'c1s1_05', 'title' => 'Сквозь тьму веков');
  $list[] = array('file' => 'c1s1_06', 'title' => 'Голубая голубая');
  $list[] = array('file' => 'c1s1_07', 'title' => 'На даче');
  $list[] = array('file' => 'c1s1_08', 'title' => 'Кукушка');
  $list[] = array('file' => 'c1s1_09', 'title' => 'Не удались безумные бравады');
  $list[] = array('file' => 'c1s1_10', 'title' => 'Телеграмма');
  $list[] = array('file' => 'c1s1_11', 'title' => 'Мальчишки мальчишки');
  $list[] = array('file' => 'c1s1_12', 'title' => 'Печален мой осенний лес');
  $list[] = array('file' => 'c1s1_13', 'title' => 'У дачного поселка осельки');
  $list[] = array('file' => 'c1s1_14', 'title' => 'Погибшим летчикам');
  $list[] = array('file' => 'c1s1_15', 'title' => 'Кто откликнется мне');
  $list[] = array('file' => 'c1s1_16', 'title' => 'Дамы');
  $list[] = array('file' => 'c1s1_17', 'title' => 'На смену серому асфальту');
  $list[] = array('file' => 'c1s1_18', 'title' => 'Майские весенние мотивы (не полностью)');
  $list[] = array('file' => 'c1s2_01', 'title' => 'Введение');
  $list[] = array('file' => 'c1s2_02', 'title' => 'Были мы с тобой');
  $list[] = array('file' => 'c1s2_03', 'title' => 'Себе налей');
  $list[] = array('file' => 'c1s2_04', 'title' => 'Матери');
  $list[] = array('file' => 'c1s2_05', 'title' => 'Мальчишки');
  $list[] = array('file' => 'c1s2_06', 'title' => 'В Ильин день');
  $list[] = array('file' => 'c1s2_07', 'title' => 'Письмо сестре');
  $list[] = array('file' => 'c1s2_08', 'title' => 'Я долго ждал желанный час');
  $list[] = array('file' => 'c1s2_09', 'title' => 'Если ты поедешь к нам на суду');
  $list[] = array('file' => 'c1s2_10', 'title' => 'Современнику');
  $list[] = array('file' => 'c1s2_11', 'title' => 'Так говоришь пенсионерка');
  $list[] = array('file' => 'c1s2_12', 'title' => 'Я живу на северной окраине');
  $list[] = array('file' => 'c1s2_13', 'title' => 'От совинформбюро');
  $list[] = array('file' => 'c1s2_14', 'title' => 'Лист исчиркав');
  $list[] = array('file' => 'c1s2_15', 'title' => 'Давно не ходим мы как прежде');
  $list[] = array('file' => 'c2s1_01', 'title' => 'Майские');
  $list[] = array('file' => 'c2s1_02', 'title' => 'Белым Цветом');
  $list[] = array('file' => 'c2s1_03', 'title' => 'В Ильин День');
  $list[] = array('file' => 'c2s1_04', 'title' => 'Шумят Деревья');
  $list[] = array('file' => 'c2s1_05', 'title' => 'Письмо Сестре 2');
  $list[] = array('file' => 'c2s2_01', 'title' => 'Вольфсоны');
  $list[] = array('file' => 'c2s2_02', 'title' => 'О чем ты с дятлом');
  $list[] = array('file' => 'c2s2_03', 'title' => 'Баллада о райкоме');
  $list[] = array('file' => 'c2s2_04', 'title' => 'Ровестники');
  $list[] = array('file' => 'c2s2_05', 'title' => 'Совинформбюро');
  $list[] = array('file' => 'c2s2_06', 'title' => 'В День Победы');
  $list[] = array('file' => 'c2s2_06b', 'title' => 'Письмо внуку (ч1)');
  $list[] = array('file' => 'c2s2_06c', 'title' => 'Письмо внуку (ч2-с линейки)');
  $list[] = array('file' => 'c2s2_06d', 'title' => 'Письмо внуку (ч2-с усилка)');
  $list[] = array('file' => 'c2s2_07b', 'title' => 'К 40-летию прорыва блокады');
  $list[] = array('file' => 'c2s2_07', 'title' => 'Тихий');
  $list[] = array('file' => 'c2s2_08', 'title' => 'Анне');

  usort($list, "cmp_title");

  return $list;
}


function get_audio_meta($index)
{
  $is_index_valid = true;
  if (!isset($index)) $is_index_valid = false;
  if (!is_numeric($index)) $is_index_valid = false;
  $index = intval($index);
  if ($index < 0) $is_index_valid = false;
  if (!$is_index_valid) return false;
  $list = get_audio_list();
  if ($index >= sizeof($list)) return false;
  return $list[$index];
}


function out_audio_list()
{
  $list = get_audio_list();
  $out = '<h3>все записи:</h3>' .
    '<ol>';
  for ($i = (0); $i < sizeof($list); $i++) {
    $out .= '<li><a href="audio.php?index=' . $i . '">' . $list[$i]["title"] . '</a></li>';
  }
  $out .= '</ol>';
  return $out;
}


function out_audiofile($element)
{
  $out = '';
  $out .= '<article class="verse">';
  // $out .= '<article style=" margin-bottom: 20px; ">';
  $out .= '<h1 class="margin_bottom_2em">' . $element['title'] . '</h1>';
  $out .= '<audio controls controlslist="nofullscreen nodownload" style=" width: 100%; ">';
  $out .= '<source src="' . get_audio_subpath() . '/' . $element['file'] . '.mp3" type="audio/mpeg" />';
  $out .= 'Ваш браузер не поддерживает тэг audio.';
  $out .= '</audio>';
  $out .= '</article>';
  return $out;
}
