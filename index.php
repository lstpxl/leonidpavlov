<?php
require_once('func.php');
require_once('preface.php');

function out_home_content()
{
	return '<article class="about">' .
		'<div class="author_container">' .
		'<h1>Леонид Павлов</h1>' .
		'<div class="author_photo"></div>' .
		'</div>' .
		'<div class="preface_container">' .
		out_my_preface() . out_editorial_preface() .
		'</div>' .
		'</artice>';
}

function out_page_home()
{
	return out_layout(get_page_title(), out_home_content(), out_verse_list());
}

print out_page_home();
