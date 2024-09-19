<?php

// $_SERVER['PROJECT_ROOT'] = $_SERVER['DOCUMENT_ROOT'];
$_SERVER['PROJECT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] . '/leonidpavlov';

function get_page_title()
{
  return "Стихи - Леонид Павлов";
};

function get_verse_dir()
{
  return $_SERVER['PROJECT_ROOT'] . '/verses';
};

function get_audio_dir()
{
  return $_SERVER['PROJECT_ROOT'] . '/audio';
};

function get_audio_subpath()
{
  // return '/audio';
  return '/leonidpavlov' . '/audio';
};

function get_verse_dir_utf8()
{
  return $_SERVER['PROJECT_ROOT'] . '/verses';
};

function get_verse_list_dir()
{
  return $_SERVER['PROJECT_ROOT'];
};
