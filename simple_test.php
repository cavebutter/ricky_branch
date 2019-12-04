<?php
require('model/database.php');
require('model/leagues_db.php');

$leagues = get_leagues();
$years = get_years();
$current_year = get_current_year();
$league_id = 1;
$teams = get_teams($league_id);
$years = filter_input(INPUT_POST, 'year');
$team_id = filter_input(INPUT_POST, 'team_id');
IF($years == NULL || $years == FALSE) {
    $year = $current_year;
}
IF($team_id == NULL || $team_id == FALSE) {
    $team_id = 28;
}
$batters = get_team_player_batting_stats($year, $team_id);
$pitchers = get_team_player_pitching_stats($year, $team_id);

 ?>
 <?php include('view/header.php'); ?>


  <?php foreach ($leagues as $league): ?>
    <li><?php echo $league['name']; ?></li>
  <?php endforeach; ?>

  <?php foreach ($teams as $team): ?>
    <p><?php echo $team['city']; ?></p>
  <?php endforeach; ?>




 <?php include('view/footer.php'); ?>
