
<?php
$pw = 'web';
$pw_hash = hash('sha256', $pw . 'Ez egy 77 karakteres \'salt\' szöveg, a jelszavas biztonság fokozása érdekében.');

echo $pw_hash;
?>