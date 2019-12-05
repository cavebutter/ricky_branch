<?php

/***************************************
The following functions are for leaderboards

*****************************************/
# Single Season Batting Stats
function season_b_leaders($league_id, $stat, $year) {
  global $db;
  if (isset($year)) {
    $year = ' AND b.year = ' . $year
  } else {
    $year = ''
  }
  $query = 'SELECT p.player_id
          , CONCAT(p.first_name, " ", p.plast_name) AS player
          , b.year
          , b.:$stat
          FROM CalcBatting b INNER JOIN players p ON b.player_id = p.player_id
          WHERE b.league_id = :league_id :year
          LIMIT 1
          ORDER BY :stat DESC';
  $statement = $db->prepare($query);
  $statement->bindValue(':league_id', $league_id);
  $statement->bindValue(':stat', $stat);
  $statement->bindValue(':year', $year);
  $statement->execute();
  $season_b_leader = $statement->fetchAll();
  $statement->closeCursor();
  return $season_b_leader;
}
?>
