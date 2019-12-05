<?php
function get_leagues() {
  global $db;
  $query = 'SELECT league_id, name, league_level FROM leagues
            ORDER BY league_level, league_id';
  $statement = $db->prepare($query);
  $statement->execute();
  $leagues = $statement->fetchAll();
  $statement->closeCursor();
  return $leagues;
}

function get_teams($league_id) {
  global $db;
  $query = 'SELECT team_id, abbr, name AS city, nickname, sub_league_id, level
            FROM teams WHERE league_id = :league_id
            ORDER BY abbr';
  $statement = $db->prepare($query);
  $statement->bindValue(':league_id', $league_id);
  $statement->execute();
  $teams = $statement->fetchAll();
  $statement->closeCursor();
  return $teams;
}

/****************************************
 * THE FOLLOWING FUNCTIONS ARE FOR ACTION: GET_ROSTER
 * The following functions will return every player's batting stats for
 * a given team in a given year
 ****************************************/
# Deternine current year
function get_current_year() {
  global $db;
  $query = 'SELECT max(year) FROM CalcBatting';
  $statement = $db->prepare($query);
  $statement->execute();
  $current_year = $statement->fetch();
  $statement->closeCursor();
}

# Get a list of all years to populate a dropdown
function get_years () {
    global $db;
    $query = 'SELECT DISTINCT year FROM CalcBatting
             ORDER BY year ASC';
    $statement = $db->prepare($query);
    $statement->execute();
    $years = $statement->fetchAll();
    $statement->closeCursor();
    return $years;
}

# Get stats for all batters
function get_team_player_batting_stats($year,$team_id) {
    global $db;
    $query = 'SELECT concat(players.first_name, " ", players.last_name) AS player
    , positions.pos_name AS pos
    , CalcBatting.g
    , CalcBatting.ab
    , CalcBatting.pa
    , CalcBatting.h
    , CalcBatting.d
    , CalcBatting.t
    , CalcBatting.hr
    , CalcBatting.bb
    , CalcBatting.k
    , CalcBatting.ba
    , CalcBatting.krate
    , CalcBatting.bbrate
    , CalcBatting.obp
    , CalcBatting.OBPplus
    , CalcBatting.slg
    , CalcBatting.ops
    , CalcBatting.iso
    , CalcBatting.babip
    , CalcBatting.woba
    , CalcBatting.wRAA
    , CalcBatting.wRC
    , CalcBatting.`wRC+`
    , CalcBatting.player_id

    FROM CalcBatting INNER JOIN players ON CalcBatting.player_id = players.player_id
        INNER JOIN positions ON players.position = positions.position
    WHERE year = :year AND CalcBatting.team_id = :team_id AND players.position <> 1
    ORDER BY CalcBatting.PA DESC, players.last_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':year', $year);
    $statement->bindValue(':team_id', $team_id);
    $statement->execute();
    $batters = $statement->fetchAll();
    $statement->closeCursor();
    return $batters;
}

# Get stats for all pitchers
function get_team_player_pitching_stats($year,$team_id) {
    global $db;
    $query = 'SELECT concat(players.first_name, " ", players.last_name) AS player
            , g
            , gs
            , ip
            , ab
            , ha
            , k
            , bb
            , bf
            , war
            , k9
            , bb9
            , HR9
            , WHIP
            , `K/BB`
            , BABIP
            , ERA
            , FIP
            , xFIP
            , ERAminus
            , ERAplus
            , FIPminus
            , CalcPitching.player_id


        FROM CalcPitching INNER JOIN players ON CalcPitching.player_id = players.player_id

        WHERE year = :year AND CalcPitching.team_id = :team_id
        ORDER BY gs DESC, players.last_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':year', $year);
    $statement->bindValue(':team_id', $team_id);
    $statement->execute();
    $pitchers = $statement->fetchAll();
    $statement->closeCursor();
    return $pitchers;
}

# Get team record data for the selected year
function get_team_year_record($year, $team_id) {
    global $db;
    $query = 'SELECT d.name as div_name, t.w, t.l, t.pos, t.pct, t.gb
              FROM team_history_record t INNER JOIN divisions d ON
              t.league_id = d.league_id AND t.sub_league_id = d.sub_league_id
              AND t.division_id = d.division_id
              WHERE year = :year AND team_id = :team_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':year', $year);
    $statement->bindValue(':team_id', $team_id);
    $statement->execute();
    $team_record = $statement->fetch();
    $statement->closeCursor();
    return $team_record;
}

# Get tean logo for display
function get_team_logo($team_id) {
  global $db;
  $query = 'SELECT logo_file_name FROM teams WHERE team_id = :team_id';
  $statement = $db->prepare($query);
  $statement->bindValue(':team_id', $team_id);
  $statement->execute();
  $logo_filename = $statement->fetch();
  $statement->closeCursor();
  return $logo_filename;
}

# Get team name and nickname for display in at the top of the page
# This may be unnecessary as we might be able to get
# it from an existing function, but it is quick and easy
function get_team_name($team_id) {
  global $db;
  $query = 'SELECT team_id, name AS city, nickname FROM teams
            WHERE team_id = :team_id';
  $statement = $db->prepare($query);
  $statement->bindValue(':team_id', $team_id);
  $statement->execute();
  $team_name = $statement->fetch();
  $statement->closeCursor();
  return $team_name;
}

#Top 3 BA leaders per team year
function get_team_ba_leaders($year,$team_id) {
  global $db;
  $query = 'SELECT b.player_id
          , CONCAT(p.first_name," ",p.last_name) AS player
          , b.ba
          FROM CalcBatting b INNER JOIN players p ON b.player_id=p.player_id
          INNER JOIN team_history_record t ON b.team_id=t.team_id AND b.year=t.year
          WHERE b.year = :year AND b.team_id = :team_id
          AND b.PA * 3.1 >= t.g
          ORDER BY b.ba DESC
          LIMIT 3';
  $statement = $db->prepare($query);
  $statement->bindValue(':year', $year);
  $statement->bindValue(':team_id', $team_id);
  $statement->execute();
  $team_ba_leaders = $statement->fetchAll();
  $statement->closeCursor();
  return $team_ba_leaders;
}

#Top 3 WAR leaders per team year
function get_team_war_leaders($year,$team_id) {
  global $db;
  $query = 'SELECT b.player_id
          , CONCAT(p.first_name," ",p.last_name) AS player
          , round(b.war,1) as war
          FROM CalcBatting b INNER JOIN players p ON b.player_id=p.player_id
          INNER JOIN team_history_record t ON b.team_id=t.team_id AND b.year=t.year
          WHERE b.year = :year AND b.team_id = :team_id
          ORDER BY b.war DESC
          LIMIT 3';
  $statement = $db->prepare($query);
  $statement->bindValue(':year', $year);
  $statement->bindValue(':team_id', $team_id);
  $statement->execute();
  $team_war_leaders = $statement->fetchAll();
  $statement->closeCursor();
  return $team_war_leaders;
}

#Top 3 wOBA leaders per team year
function get_team_woba_leaders($year,$team_id) {
  global $db;
  $query = 'SELECT b.player_id
          , CONCAT(p.first_name," ",p.last_name) AS player
          , b.woba
          FROM CalcBatting b INNER JOIN players p ON b.player_id=p.player_id
          INNER JOIN team_history_record t ON b.team_id=t.team_id AND b.year=t.year
          WHERE b.year = :year AND b.team_id = :team_id
          AND b.PA * 3.1 >= t.g
          ORDER BY b.woba DESC
          LIMIT 3';
  $statement = $db->prepare($query);
  $statement->bindValue(':year', $year);
  $statement->bindValue(':team_id', $team_id);
  $statement->execute();
  $team_woba_leaders = $statement->fetchAll();
  $statement->closeCursor();
  return $team_woba_leaders;
}

# Top 3 WAR pitchers per team year
function get_team_p_war_leaders($year,$team_id) {
  global $db;
  $query = 'SELECT p.player_id
            , CONCAT(pl.first_name," ",pl.last_name) as player
            , round(p.war,1) as war
            FROM CalcPitching p INNER JOIN players pl ON p.player_id=pl.player_id
            WHERE p.year = :year AND p.team_id = :team_id
            ORDER BY p.war DESC
            LIMIT 3';
  $statement = $db->prepare($query);
  $statement->bindValue(':year', $year);
  $statement->bindValue(':team_id', $team_id);
  $statement->execute();
  $team_p_war_leaders = $statement->fetchAll();
  $statement->closeCursor();
  return $team_p_war_leaders;
}

#Top 3 FIP- leaders per team year
function get_team_fipm_leaders($year,$team_id) {
  global $db;
  $query = 'SELECT p.player_id
          , CONCAT(pl.first_name," ",pl.last_name) AS player
          , p.FIPminus
          FROM CalcPitching p INNER JOIN players pl ON p.player_id=pl.player_id
          INNER JOIN team_history_record t ON p.team_id=t.team_id AND p.year=t.year
          WHERE p.year = :year AND p.team_id = :team_id
          AND p.g  >= 35
          ORDER BY p.FIPminus
          LIMIT 3';
  $statement = $db->prepare($query);
  $statement->bindValue(':year', $year);
  $statement->bindValue(':team_id', $team_id);
  $statement->execute();
  $team_fipm_leaders = $statement->fetchAll();
  $statement->closeCursor();
  return $team_fipm_leaders;
}

#Top 3 WHIP leaders per team year
function get_team_whip_leaders($year,$team_id) {
  global $db;
  $query = 'SELECT p.player_id
          , CONCAT(pl.first_name," ",pl.last_name) AS player
          , p.whip
          FROM CalcPitching p INNER JOIN players pl ON p.player_id=pl.player_id
          INNER JOIN team_history_record t ON p.team_id=t.team_id AND p.year=t.year
          WHERE p.year = :year AND p.team_id = :team_id
          AND p.g  >= 35
          ORDER BY p.whip
          LIMIT 3';
  $statement = $db->prepare($query);
  $statement->bindValue(':year', $year);
  $statement->bindValue(':team_id', $team_id);
  $statement->execute();
  $team_whip_leaders = $statement->fetchAll();
  $statement->closeCursor();
  return $team_whip_leaders;
}

/*****************************************************
The following functions will be used to build player cards.
ACTION: GET_PLAYER
******************************************************/
# Major League batting stats
function get_player_ml_batting_stats($player_id) {
  global $db;
  $query = 'SELECT b.player_id
            , b.year
            , b.year - YEAR(p.date_of_birth) AS age
            , b.team_id
            , b.level_id
            , b.league_id
            , l.abbr as league
            , b.g
            , b.ab
            , b.PA
            , b.r
            , b.h
            , b.d
            , b.t
            , b.hr
            , b.rbi
            , b.sb
            , b.cs
            , b.bb
            , b.k
            , b.ibb
            , b.hp
            , b.sh
            , b.sf
            , b.gdp
            , b.ci
            , b.war
            , b.ba
            , b.krate
            , b.bbrate
            , b.obp
            , b.OBPplus
            , b.woba
            , b.slg
            , b.ops
            , b.iso
            , b.babip
            , b.wRAA
            , b.wRC
            , b.`wRC+`
            , concat(p.first_name," ", p.last_name) AS player
            , t.name as city
            , t.nickname
            , t.abbr
            FROM CalcBatting b INNER JOIN players p ON b.player_id = p.player_id
            INNER JOIN teams t ON b.team_id = t.team_id
            INNER JOIN leagues l ON b.league_id = l.league_id
            WHERE b.level_id = 1 AND b.player_id = :player_id
            ORDER BY b.year';
    $statement = $db->prepare($query);
    $statement->bindValue('player_id', $player_id);
    $statement->execute();
    $ml_batting_stats = $statement->fetchAll();
    $statement->closeCursor();
    return $ml_batting_stats;
}
# Get minor league batting stats, ordered by year, then level asc
function get_player_mil_batting_stats($player_id) {
  global $db;
  $query = 'SELECT b.player_id
            , b.year
            , b.year - YEAR(p.date_of_birth) AS age
            , b.team_id
            , b.level_id
            , b.league_id
            , l.abbr as league
            , b.g
            , b.ab
            , b.PA
            , b.r
            , b.h
            , b.d
            , b.t
            , b.hr
            , b.rbi
            , b.sb
            , b.cs
            , b.bb
            , b.k
            , b.ibb
            , b.hp
            , b.sh
            , b.sf
            , b.gdp
            , b.ci
            , b.war
            , b.ba
            , b.krate
            , b.bbrate
            , b.obp
            , b.OBPplus
            , b.woba
            , b.slg
            , b.ops
            , b.iso
            , b.babip
            , b.wRAA
            , b.wRC
            , b.`wRC+`
            , concat(p.first_name," ", p.last_name) AS player
            , t.name as city
            , t.nickname
            , t.abbr
            FROM CalcBatting b INNER JOIN players p ON b.player_id = p.player_id
            INNER JOIN teams t ON b.team_id = t.team_id
            INNER JOIN leagues l ON b.league_id = l.league_id
            WHERE b.level_id <> 1 AND b.player_id = :player_id
            ORDER BY b.year';
    $statement = $db->prepare($query);
    $statement->bindValue('player_id', $player_id);
    $statement->execute();
    $mil_batting_stats = $statement->fetchAll();
    $statement->closeCursor();
    return $mil_batting_stats;
}
# Get major league fielding stats
function get_ml_fielding_stats($player_id) {
  global $db;
  $query = 'SELECT f.player_id,
            f.year,
            f.year - YEAR(p.date_of_birth) AS age,
            f.team_id,
            f.league_id,
            l.abbr as league,
            f.level_id,
            f.split_id,
            po.pos_name,
            f.tc,
            f.a,
            f.po,
            f.er,
            f.ip,
            f.g,
            f.gs,
            f.e,
            f.dp,
            f.tp,
            f.pb,
            f.sba,
            f.rto,
            f.ipf,
            f.plays,
            f.plays_base,
            f.roe,
            f.opps_0,
            f.opps_made_0,
            f.opps_1,
            f.opps_made_1,
            f.opps_2,
            f.opps_made_2,
            f.opps_3,
            f.opps_made_3,
            f.opps_4,
            f.opps_made_4,
            f.opps_5,
            f.opps_made_5,
            f.zr,
            concat(p.first_name," ",p.last_name) AS player
            , t.name as city
            , t.nickname
            , t.abbr
            FROM players_career_fielding_stats f INNER JOIN players p ON
            f.player_id = p.player_id
            INNER JOIN teams t ON f.team_id = t.team_id
            INNER JOIN positions po ON f.position = po.position
            INNER JOIN leagues l ON f.league_id = l.league_id
            WHERE f.level_id = 1 AND f.player_id = :player_id
            ORDER BY f.year, t.abbr, po.pos_name';
  $statement = $db->prepare($query);
  $statement->bindValue(':player_id', $player_id);
  $statement->execute();
  $ml_fielding_stats = $statement->fetchAll();
  $statement->closeCursor();
  return $ml_fielding_stats;
}
# Get minor league fielding stats
function get_mil_fielding_stats($player_id) {
  global $db;
  $query = 'SELECT f.player_id,
            f.year,
            f.year - YEAR(p.date_of_birth) AS age,
            f.team_id,
            f.league_id,
            l.abbr as league,
            f.level_id,
            f.split_id,
            po.pos_name,
            f.tc,
            f.a,
            f.po,
            f.er,
            f.ip,
            f.g,
            f.gs,
            f.e,
            f.dp,
            f.tp,
            f.pb,
            f.sba,
            f.rto,
            f.ipf,
            f.plays,
            f.plays_base,
            f.roe,
            f.opps_0,
            f.opps_made_0,
            f.opps_1,
            f.opps_made_1,
            f.opps_2,
            f.opps_made_2,
            f.opps_3,
            f.opps_made_3,
            f.opps_4,
            f.opps_made_4,
            f.opps_5,
            f.opps_made_5,
            f.zr,
            concat(p.first_name," ",p.last_name) AS player
            , t.name as city
            , t.nickname
            , t.abbr
            FROM players_career_fielding_stats f INNER JOIN players p ON
            f.player_id = p.player_id
            INNER JOIN teams t ON f.team_id = t.team_id
            INNER JOIN positions po ON f.position = po.position
            INNER JOIN leagues l ON b.league_id = l.league_id
            WHERE f.level_id <> 1 AND f.player_id = :player_id
            ORDER BY f.year, f.level_id, t.abbr, po.pos_name';
  $statement = $db->prepare($query);
  $statement->bindValue(':player_id', $player_id);
  $statement->execute();
  $mil_fielding_stats = $statement->fetchAll();
  $statement->closeCursor();
  return $mil_fielding_stats;
}
function get_ml_pitching_stats($player_id) {
  global $db;
  $query = 'SELECT p.player_id
          , p.year
          , p.year - YEAR(pl.date_of_birth) AS age
          , p.level_id
          , l.abbr as league
          , p.ab
          , p.tb
          , p.ha
          , p.ip
          , p.ipf
          , p.k
          , p.bf
          , p.rs
          , p.bb
          , p.r
          , p.er
          , p.gb
          , p.fb
          , p.pi
          , p.g
          , p.gs
          , p.w
          , p.l
          , p.s
          , p.sa
          , p.da
          , p.ta
          , p.hra
          , p.sh
          , p.sf
          , p.bk
          , p.ci
          , p.iw
          , p.wp
          , p.hp
          , p.gf
          , p.dp
          , p.qs
          , p.svo
          , p.bs
          , p.ra
          , p.cg
          , p.sho
          , p.sb
          , p.cs
          , p.hld
          , p.ir
          , p.irs
          , p.wpa
          , p.li
          , p.outs
          , p.war
          , p.InnPitch
          , p.k9
          , p.bb9
          , p.HR9
          , p.WHIP
          , p.`K/BB`
          , p.`gb/fb`
          , p.BABIP
          , p.ERA
          , p.FIP
          , p.xFIP
          , p.ERAminus
          , p.ERAplus
          , p.FIPminus
          , concat(pl.first_name," ",pl.last_name) AS player
          , t.name as city
          , t.nickname
          , t.abbr
          FROM CalcPitching p INNER JOIN players pl ON p.player_id = pl.player_id
          INNER JOIN teams t ON p.team_id = t.team_id
          INNER JOIN leagues l ON p.league_id = l.league_id
          WHERE p.level_id = 1 AND p.player_id = :player_id
          ORDER BY p.year';
  $statement=$db->prepare($query);
  $statement->bindValue(':player_id', $player_id);
  $statement->execute();
  $ml_pitching_stats = $statement->fetchAll();
  $statement->closeCursor();
  return $ml_pitching_stats;
}
# Get minor league pitching stats
function get_mil_pitching_stats($player_id) {
  global $db;
  $query = 'SELECT p.player_id
          , p.year
          , p.year - YEAR(pl.date_of_birth) AS age
          , p.level_id
          , l.abbr as league
          , p.ab
          , p.tb
          , p.ha
          , p.ip
          , p.ipf
          , p.k
          , p.bf
          , p.rs
          , p.bb
          , p.r
          , p.er
          , p.gb
          , p.fb
          , p.pi
          , p.g
          , p.gs
          , p.w
          , p.l
          , p.s
          , p.sa
          , p.da
          , p.ta
          , p.hra
          , p.sh
          , p.sf
          , p.bk
          , p.ci
          , p.iw
          , p.wp
          , p.hp
          , p.gf
          , p.dp
          , p.qs
          , p.svo
          , p.bs
          , p.ra
          , p.cg
          , p.sho
          , p.sb
          , p.cs
          , p.hld
          , p.ir
          , p.irs
          , p.wpa
          , p.li
          , p.outs
          , p.war
          , p.InnPitch
          , p.k9
          , p.bb9
          , p.HR9
          , p.WHIP
          , p.`K/BB`
          , p.`gb/fb`
          , p.BABIP
          , p.ERA
          , p.FIP
          , p.xFIP
          , p.ERAminus
          , p.ERAplus
          , p.FIPminus
          , concat(pl.first_name," ",pl.last_name) AS player
          , t.name as city
          , t.nickname
          , t.abbr
          FROM CalcPitching p INNER JOIN players pl ON p.player_id = pl.player_id
          INNER JOIN teams t ON p.team_id = t.team_id
          INNER JOIN leagues l ON p.league_id = l.league_id
          WHERE p.level_id <> 1 AND p.player_id = :player_id
          ORDER BY p.year, p.level_id, t.abbr';
  $statement=$db->prepare($query);
  $statement->bindValue(':player_id', $player_id);
  $statement->execute();
  $mil_pitching_stats = $statement->fetchAll();
  $statement->closeCursor();
  return $mil_pitching_stats;
}
# Get player biographical information
function get_player_bio($player_id) {
  global $db;
  $query = 'SELECT p.player_id
            , po.pos_name
            , concat(p.first_name, " ", p.last_name) AS player
            , p.nick_name
            , p.age
            , p.date_of_birth
            , c.name as city
            , s.abbreviation as state
            , n.abbreviation as nation
            , p.weight
            , p.height
            , CASE
                WHEN p.retired = 1 THEN "Retired"
                WHEN p.retired = 0 AND p.free_agent=1 THEN "Free Agent"
                ELSE CONCAT(t.name," ",t.nickname) END AS status
            , p.uniform_number
            , p.experience
            , p.bats
            , p.throws
            , p.draft_year
            , p.draft_round
            , p.draft_pick
            , p.draft_overall_pick
            , concat(t1.name," ",t1.nickname) AS drafted_by
            , IF(p.turned_coach=1,"Yes","No") AS coach
            , IF(p.hall_of_fame=1, concat("Inducted to Hall of Fame ", p.inducted),"") AS HOF
            FROM players p INNER JOIN positions po ON p.position = po.position
            INNER JOIN cities c ON p.city_of_birth_id = c.city_id
            INNER JOIN states s ON c.state_id = s.state_id
            INNER JOIN nations n ON p.nation_id = n.nation_id
            LEFT JOIN teams t ON p.team_id = t.team_id
            LEFT JOIN teams t1 ON p.draft_team_id = t1.team_id
            WHERE p.player_id = :player_id';
  $statement = $db->prepare($query);
  $statement -> bindValue(':player_id', $player_id);
  $statement->execute();
  $player_bio = $statement->fetch();
  $statement->closeCursor();
  return $player_bio;
}

function is_pitcher($player_id)  {
  global $db;
  $query = 'SELECT IF (position = 1, 1, 0) AS is_pitcher FROM players WHERE player_id = :player_id';
  $statement = $db->prepare($query);
  $statement->bindValue(':player_id', $player_id);
  $statement->execute();
  $is_pitcher = $statement->fetch();
  $statement->closeCursor();
  return $is_pitcher;

}

/******************************************
THE FOLLOWING FUNCTIONS SUPPORT ACTION:
team_home
*******************************************/
/*function get_team_info($team_id) {
  global $db;
  $query = 'SELECT t.team_id
    , t.name
    , t.nickname
    , t.logo_file_name
    , l.name as league
    , l.abbr as league_abbr
    , s.name as sub_league_name
    , s.abbr as sub_league_abbr
    , d.name as div_name
    FROM teams t INNER JOIN leagues l ON t.league_id = l.league_id
    INNER JOIN sub_leagues s ON t.league_id = s.league_id AND t.sub_league_id = s.sub_league_id
    INNER JOIN divisions d ON t.league_id = d.league_id AND t.sub_league_id = d.sub_league_id
    AND t.division_id = d.division_id
    WHERE d.team_id = :team_id';
  $statement = $db->prepare($query);
  $statement ->bindValue('team_id', $team_id);
  $statement->execute();
  $team_info = $statement->fetchAll();
  $statement->closeCursor();
  return $team_info;
}
*/

function get_team_info($team_id) {
  global $db;
  $query = 'SELECT t.team_id
    , t.name
    , t.nickname
    , t.logo_file_name
    , l.name as league
    , l.abbr as league_abbr
    , s.name as sub_league_name
    , s.abbr as sub_league_abbr
    , d.name as div_name
    FROM teams t INNER JOIN leagues l ON t.league_id = l.league_id
    INNER JOIN sub_leagues s ON t.league_id = s.league_id AND t.sub_league_id = s.sub_league_id
    INNER JOIN divisions d ON t.league_id = d.league_id AND t.sub_league_id = d.sub_league_id
    AND t.division_id = d.division_id
    WHERE t.team_id = :team_id';
  $statement = $db->prepare($query);
  $statement->bindValue('team_id', $team_id);
  $statement->execute();
  $team_info = $statement->fetch();
  $statement->closeCursor();
  return $team_info;
}

function get_current_record($team_id) {
  global $db;
  $query = 'SELECT * FROM team_record
            WHERE team_id = :team_id';
  $statement = $db->prepare($query);
  $statement->bindValue('team_id', $team_id);
  $statement->execute();
  $current_record = $statement->fetchAll();
  $statement->closeCursor();
  return $current_record;
}

function get_team_historical_record($team_id) {
  global $db;
  $query = 'SELECT thr.team_id            # [0]
    , thr.year                            # [1]
    , thr.g                               # [2]
    , thr.w                               # [3]
    , thr.l                               # [4]
    , thr.pos                             # [5]
    , round(thr.pct,3) as pct             # [6]
    , thr.gb                              #[7]
FROM team_history_record thr 
WHERE thr.team_id = :team_id';
  $statement = $db->prepare($query);
  $statement->bindValue('team_id', $team_id);
  $statement->execute();
  $team_historical_record = $statement->fetchAll();
  $statement->closeCursor();
  return $team_historical_record;
}
 ?>
