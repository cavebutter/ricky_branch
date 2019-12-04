<?php
require('model/database.php');
require('model/leagues_db.php');


  $action = filter_input(INPUT_GET, 'action');
  if ($action == NULL) {
    $action = 'select_team_year'; //establishes team_roster as default action
  }


if ($action == 'select_team_year') {
    $leagues = get_leagues();
    $current_year = get_current_year();
    $league_id = filter_input(INPUT_GET, 'league_id'); //Try to get $league_id from post
    if ($league_id == NULL || $league_id == FALSE) {
      $league_id = 1; //If nothing posted, defaults to 1
    }
    $year = filter_input(INPUT_POST, 'year'); //Try to get $year from post
    if ($year == NULL || $year == FALSE) {
        $year = $current_year; // If nothing has posted, defaults to $current_year
    }
    $years = get_years(); //Get all years in league history
    $teams = get_teams($league_id);  //Get list of teams for selected league
    include('select_team_year.php');
}

if ($action == 'get_roster') {
  $year = filter_input(INPUT_GET, 'year'); //Get year from form
  if ($year == NULL || $year == FALSE) {
    $error_message = 'Please make sure that you choose a year from the dropdown.';
    include('errors/other_error.php');
  }
  $team_id = filter_input(INPUT_GET, 'team_id');
  if ($team_id == NULL || $team_id == FALSE) {
    $error_message = "Please make sure that you select a team from the dropdown.";
    include('errors/other_error.php');
  }
  $batters = get_team_player_batting_stats($year,$team_id);
  $pitchers = get_team_player_pitching_stats($year,$team_id);
  $logo_filename = get_team_logo($team_id);
  $team_logo_path = 'images/team_logos/'.$logo_filename['logo_file_name'];
  $team_name = get_team_name($team_id);
  $combined_name = $team_name['city'].' '.$team_name['nickname'];
  $team_record = get_team_year_record($year, $team_id);
  $caption = 'Finished #'.$team_record['pos'].' In '.$team_record['div_name'];
  $team_ba_leaders = get_team_ba_leaders($year,$team_id);
  $team_war_leaders = get_team_war_leaders($year,$team_id);
  $team_woba_leaders = get_team_woba_leaders($year,$team_id);
  $team_p_war_leaders = get_team_p_war_leaders($year,$team_id);
  $team_fipm_leaders = get_team_fipm_leaders($year,$team_id);
  $team_whip_leaders = get_team_whip_leaders($year,$team_id);
  include('team_roster.php');
}

if ($action == 'get_player') {
  $player_id = filter_input(INPUT_GET, 'player_id');
  $is_pitcher = is_pitcher($player_id);
  if ($is_pitcher[0] == 0) {
      $message = '$is_pitcher evaluation: batter';
  } else {
      $message = '$is_pitcher evaluation: pitcher';
  }

  $player_ml_b_stats = get_player_ml_batting_stats($player_id);
  $player_mil_b_stats = get_player_mil_batting_stats($player_id);
  $player_ml_p_stats = get_ml_pitching_stats($player_id);
  $player_mil_p_stats = get_mil_pitching_stats($player_id);
  $player_ml_f_stats = get_ml_fielding_stats($player_id);
  $player_mil_f_stats = get_mil_fielding_stats($player_id);
  $player_bio = get_player_bio($player_id);
  $height_ft = intdiv(($player_bio['height'] * .393701), 12); //height to inches, /12
  $height_in = ($player_bio['height'] * .393701) % 12;

  if ($player_bio['bats'] == 3) {
    $bats = 'Switch';
  } else if ($player_bio['bats'] == 2) {
    $bats = 'Left';
  } else if ($player_bio['bats'] == 1) {
    $bats = 'Right';
  }
  if ($player_bio['throws'] == 3) {
    $throws = 'S';
  } else if ($player_bio['throws'] == 2) {
    $throws = 'Left';
  } else if ($player_bio['throws'] == 1) {
    $throws = 'Right';
  }
  if ($player_bio['draft_year'] == 0) {
      $draft_year = 'Inaugural Draft';
  } else {
      $draft_year = $player_bio['draft_year'];
  }
  if ($is_pitcher[0] == 0) {
    include('batter_player_card.php');
    include('player_card_var_test.php'); //Use this file to check variables
  } else if ($is_pitcher[0] == 1){
    include('pitcher_player_card.php');
    include('player_card_var_test.php'); //Use this file to check variables
  }

}

if ($action == 'team_home') {
  $team_id = filter_input(INPUT_GET, 'team_id');
  $team_info = get_team_info($team_id);
  $current_year = get_current_year();
  $current_record = get_current_record($team_id);
  $team_historical_record = get_team_historical_record($team_id);
  $logo_filename = get_team_logo($team_id);
  $team_logo_path = 'images/team_logos/'.$logo_filename['logo_file_name'];
  include('team_home.php');
  include('team_home_var_test.php');
}
?>
