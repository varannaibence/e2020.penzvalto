<?php

     $pw = htmlspecialchars($_GET['kod']);
     $pw_hash = hash('sha256', $pw . 'Ez egy 77 karakteres \'salt\' szöveg, a jelszavas biztonság fokozása érdekében.');
     if ($pw_hash == '26f111e8e36b8821bc874a675f9e1579679641ea7036b11c64cfc0d159edcbb3')
        {include 'index_web.html';}
     else{
        if ($pw_hash == '912a04fe392b059dd3745a468298ebc134269b5f77c3051df1b0cc8593b58991') {
         include 'EgZjaHJvbWUyBggAEEUYOTIGCAEQRRg8MgYIAhAuGEDSAQgyMzIwajBqOagCALACAA.html';
        } 
        else{
         include 'index_login.html';
        }
        
     }
  

?>