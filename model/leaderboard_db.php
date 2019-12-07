<?php
namespace leaders {
  /***************************
  Team Leaders
  ***************************/

  function team_all_time_b_leaders($team_id, $stat) {
    global $db;
    $query = 'SELECT b.player_id
   , CONCAT(p.last_name, ", ",p.first_name) as Player
   , pos.pos_name AS Pos
   , sum(b.g) AS G
   , sum(b.ab) AS AB
   , sum(b.r) AS R
   , sum(b.h) AS H
   , sum(b.d) AS 2B
   , sum(b.t) AS 3B
   , sum(b.hr) AS HR
   , sum(b.rbi) AS RBI
   , sum(b.bb) AS BB
   , sum(b.k) AS SO
   , sum(b.sb) AS SB
   , sum(b.cs) AS CS
   , TRIM(LEADING "0" FROM round(sum(b.h)/sum(b.ab),3)) AS Avg
   , TRIM(LEADING "0" FROM round((sum(b.h)+sum(b.bb)+sum(b.hp))/(sum(b.ab)+sum(b.bb)+sum(b.hp)+sum(b.sf)),3)) AS OBP
   , ((sum(b.h) - sum(b.d) - sum(b.t) - sum(hr))) + (2*sum(b.d)) + (3*sum(b.t)) + (4*sum(b.hr)) AS TB
   , TRIM(LEADING "0" FROM round((((sum(b.h) - sum(b.d) - sum(b.t) - sum(hr))) + (2*sum(b.d)) + (3*sum(b.t)) + (4*sum(b.hr))) / sum(b.ab),3)) AS SLG
   , round(TRIM(LEADING "0" FROM round((sum(b.h)+sum(b.bb)+sum(b.hp))/(sum(b.ab)+sum(b.bb)+sum(b.hp)+sum(b.sf)),3)) + TRIM(LEADING "0" FROM round((((sum(b.h) - sum(b.d) - sum(b.t) - sum(hr))) + (2*sum(b.d)) + (3*sum(b.t)) + (4*sum(b.hr))) / sum(b.ab),3)),3) AS OPS
   , sum(b.hp) AS HBP
   , sum(b.ibb) AS IBB
   , sum(b.SH) AS SAC
   , sum(b.sf) AS SF
   , sum(b.PA) as PA
    FROM CalcBatting b INNER JOIN players p ON b.player_id = p.player_id
        INNER JOIN positions pos ON p.position = pos.position
    WHERE b.team_id = :team_id AND p.position <>1
    GROUP BY b.player_id, Player, POS
    ORDER BY :stat DESC
    LIMIT 50';

    $statement = $db->prepare($query);
    $statement->bindValue(':team_id', $team_id);
    $statement->bindValue(':stat', $stat);
    $statement->execute();
    $team_all_time_b_leaders = $statement->fetchAll();
    $statement->closeCursor();
    return $team_all_time_b_leaders;
  }

  function b_stat_names() {
    $b_stat_names = array (G, AB, R, H, 2B, 3B, HR, RBI, BB, SO, SB, CS, Avg, OBP, TB, SLG, OPS,
                            HBP, IBB, SAC, SF, PA)
    return $b_stat_names;
  }
}
?>
