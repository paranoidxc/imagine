<?php
class Fun {  
  static function candy(){
    $a = array('&diams;', '&hearts;','&clubs;','&spades;','&loz;','&bull;',
      '&Scaron;','&otimes;','&oplus;' );
    $a = array('♧','♡', '♤','♢','♠','♣','♥','♦',
    '♥','★','☆',
    '☺','☹',
    '☂','☃',
    '♔','♕','♖','♘','♆','✠',
    '☠',
    '☣',
    '&#042');
    return $a[array_rand($a)];
  }  
}
?>