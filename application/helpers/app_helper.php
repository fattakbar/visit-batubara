<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function level($id='')
{
  if ($id == 1) {
    $a = 'Super User';
  } else if ($id == 2) {
    $a = 'Administrasi';
  } else {
    $a = 'Not Found';
  }

  return $a;
}
