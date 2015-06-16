<?php
require('auth_seed.php');
$auth = new authSeed();

echo $auth->fetchComputation('6trio78okjuuiy7ik78olkjerwhwty7ikri67i', time());

