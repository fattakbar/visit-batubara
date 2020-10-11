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

function status($id='')
{
  if ($id == 1) {
    $a = '<span class="badge badge-success">Active</span>';
  } else {
    $a = '<span class="badge badge-warning">Not Active</span>';
  }

  return $a;
}