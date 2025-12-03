<?php

namespace App\Core;

class FileManeger
{
 public static function read($path) : ?string
 {
     if (file_exists($path)) {
         return file_get_contents($path);
     }
     return null;

 }
 public static function write($path, $content) : bool
 {
     return file_put_contents($path, $content, FILE_APPEND) != false;
 }
}