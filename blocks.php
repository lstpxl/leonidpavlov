<?php

function out_head($title)
{
  return '<!DOCTYPE html>
<html lang="ru">
<head>
  <title>' . $title . '</title>
  <meta charset="UTF-8" />
  <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
  <meta HTTP-EQUIV="Pragma" content="no-cache" />
  <meta HTTP-EQUIV="Expires" content="-1" />
  <link rel="stylesheet" href="base.css?q=9" type="text/css" />
  <meta name="viewport" content="width=device-width" />
</head>' . PHP_EOL;
}

function out_header()
{
  return '<body>
<div class="wholepage">
<header>
<h2>Стихи Леонида Павлова</h2>
<div>
<nav>
  <a href="index.php" class="about">об авторе</a>
  <a href="audio.php?index=0" class="audio">аудиозаписи</a>
</nav>
</div>
</header>' . PHP_EOL;
}

function out_foot()
{
  return '<footer>
  <p>&copy; 1971 &ndash; 1998, Леонид Павлов</p>
  <p>Ведение архива 2002 &ndash; 2009, Илья Павлов</p>
</footer>
</div>
</body>
</html>';
}

function out_layout($page_title, $main, $sidebar)
{
  $result = out_head($page_title);
  $result .= out_header();
  $result .= '<section class="middle">';
  $result .= '<main><div class="main_container">' . $main . '</div></main>';
  $result .= '<aside>' . $sidebar . '</aside>';
  $result .= '</section>';
  $result .=  out_foot();
  return $result;
}
