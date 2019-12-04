<?php include('view/header.php'); ?>


<h1><?php echo $player_bio['player'] ;?></h1>
<img class="card" src="<?php echo "images/person_pictures/player_".$player_bio['player_id'].".png"; ?>">
<h3><?php echo "  |  BORN:  ".$player_bio['date_of_birth']
        ."  |  ".$player_bio['city']
        .", ".$player_bio['state']
        .", ".$player_bio['nation'];?></h3>


<h3><?php echo "  |  ".$height_ft."'".$height_in.'"  |  '
        .$player_bio['weight']." lbs  |  "
        .$player_bio['status']."  |  ";?></h3>

<h4><?php echo "  |  ".$player_bio['pos_name']
        ."  |  Bats: "
        .$bats
        ."  |  Throws: "
        .$throws
        ."  |  #  "
        .$player_bio['uniform_number']
        ."  |";?></h4>

<h4><?php echo "|  Drafted by ".$player_bio['drafted_by']
        ." in  "
        .$draft_year
        .", Round #"
        .$player_bio['draft_round']
        ." , number "
        .$player_bio['draft_overall_pick']
        ." overall  |  ";?></h4>

<table>
  <thead>
    Major League Pitching Stats (Traditional)
  </thead>
  <th>Year</th><th>Age</th><th>Team</th><th>W</th><th>L</th><th>ERA</th><th>G</th><th>GS</th><th>CG</th><th>SHO</th>
  <th>QS</th><th>SV</th><th>BS</th><th>IP</th><th>H</th><th>R</th><th>ER</th><th>HR</th><th>BB</th><th>SO</th><th>HBP</th>
  <th>BK</th><th>WP</th><th>BF</th>
  <?php foreach ($player_ml_p_stats as $player_year) : ?>
    <tr>
    <td><?php echo $player_year['year']; ?></td>
    <td><?php echo $player_year['age']; ?></td>
    <td><a href="index.php?action=get_roster&team_id=<?php echo $player_year['team_id'];?>&year=<?php echo $player_year['year'];?>"><?php echo $player_year['abbr'] ?></a></td>
    <td><?php echo $player_year['w']; ?></td>
    <td><?php echo $player_year['l']; ?></td>
    <td><?php echo $player_year['ERA']; ?></td>
    <td><?php echo $player_year['g']; ?></td>
    <td><?php echo $player_year['gs']; ?></td>
    <td><?php echo $player_year['cg']; ?></td>
    <td><?php echo $player_year['sho']; ?></td>
    <td><?php echo $player_year['qs']; ?></td>
    <td><?php echo $player_year['s']; ?></td>
    <td><?php echo $player_year['bs']; ?></td>
    <td><?php echo $player_year['ip'].'.'.$player_year['ipf']; ?></td>
    <td><?php echo $player_year['ha']; ?></td>
    <td><?php echo $player_year['r']; ?></td>
    <td><?php echo $player_year['er']; ?></td>
    <td><?php echo $player_year['hra']; ?></td>
    <td><?php echo $player_year['bb']; ?></td>
    <td><?php echo $player_year['k']; ?></td>
    <td><?php echo $player_year['hp']; ?></td>
    <td><?php echo $player_year['bk']; ?></td>
    <td><?php echo $player_year['wp']; ?></td>
    <td><?php echo $player_year['bf']; ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<table>
  <thead>
    Major League Pitching Stats (Advanced)
  </thead>
  <th>Year</th><th>Age</th><th>Team</th><th>WAR</th><th>K9</th><th>BB9</th><th>K/BB</th>
  <th>HR9</th><th>WHIP</th><th>GB/FB</th><th>BABIP</th><th>FIP</th><th>xFIP</th><th>FIP-</th><th>ERA-</th><th>ERA+</th>
<?php foreach ($player_ml_p_stats as $player_year): ?>
  <tr>
    <td><?php echo $player_year['year']; ?></td>
    <td><?php echo $player_year['age']; ?></td>
    <td><a href="index.php?action=get_roster&team_id=<?php echo $player_year['team_id'];?>&year=<?php echo $player_year['year'];?>"><?php echo $player_year['abbr'] ?></a></td>
    <td><?php echo round($player_year['war'],1); ?></td>
    <td><?php echo $player_year['k9']; ?></td>
    <td><?php echo $player_year['bb9']; ?></td>
    <td><?php echo $player_year['K/BB']; ?></td>
    <td><?php echo $player_year['HR9']; ?></td>
    <td><?php echo $player_year['WHIP']; ?></td>
    <td><?php echo round($player_year['gb/fb'],3); ?></td>
    <td><?php echo ltrim($player_year['BABIP'],"0"); ?></td>
    <td><?php echo $player_year['FIP']; ?></td>
    <td><?php echo $player_year['xFIP']; ?></td>
    <td><?php echo $player_year['FIPminus']; ?></td>
    <td><?php echo $player_year['ERAminus']; ?></td>
    <td><?php echo $player_year['ERAplus']; ?></td>
  </tr>
<?php endforeach; ?>
</table>

<table>
  <thead>
    Minor League Pitching Stats (Traditional)
  </thead>
  <th>Year</th><th>Age</th><th>Team</th><th>Lg</th><th>W</th><th>L</th><th>ERA</th><th>G</th><th>GS</th><th>CG</th><th>SHO</th>
  <th>QS</th><th>SV</th><th>BS</th><th>IP</th><th>H</th><th>R</th><th>ER</th><th>HR</th><th>BB</th><th>SO</th><th>HBP</th>
  <th>BK</th><th>WP</th><th>BF</th>
  <?php foreach ($player_mil_p_stats as $player_year) : ?>
    <tr>
    <td><?php echo $player_year['year']; ?></td>
    <td><?php echo $player_year['age']; ?></td>
    <td><a href="index.php?action=get_roster&team_id=<?php echo $player_year['team_id'];?>&year=<?php echo $player_year['year'];?>"><?php echo $player_year['abbr'] ?></a></td>
    <td><?php echo $player_year['league']; ?></td>
    <td><?php echo $player_year['w']; ?></td>
    <td><?php echo $player_year['l']; ?></td>
    <td><?php echo $player_year['ERA']; ?></td>
    <td><?php echo $player_year['g']; ?></td>
    <td><?php echo $player_year['gs']; ?></td>
    <td><?php echo $player_year['cg']; ?></td>
    <td><?php echo $player_year['sho']; ?></td>
    <td><?php echo $player_year['qs']; ?></td>
    <td><?php echo $player_year['s']; ?></td>
    <td><?php echo $player_year['bs']; ?></td>
    <td><?php echo $player_year['ip'].'.'.$player_year['ipf']; ?></td>
    <td><?php echo $player_year['ha']; ?></td>
    <td><?php echo $player_year['r']; ?></td>
    <td><?php echo $player_year['er']; ?></td>
    <td><?php echo $player_year['hra']; ?></td>
    <td><?php echo $player_year['bb']; ?></td>
    <td><?php echo $player_year['k']; ?></td>
    <td><?php echo $player_year['hp']; ?></td>
    <td><?php echo $player_year['bk']; ?></td>
    <td><?php echo $player_year['wp']; ?></td>
    <td><?php echo $player_year['bf']; ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<table>
  <thead>
    Minor League Pitching Stats (Advanced)
  </thead>
  <th>Year</th><th>Age</th><th>Team</th><th>Lg</th><th>WAR</th><th>K9</th><th>BB9</th><th>K/BB</th>
  <th>HR9</th><th>WHIP</th><th>GB/FB</th><th>BABIP</th><th>FIP</th><th>xFIP</th><th>FIP-</th><th>ERA-</th><th>ERA+</th>
<?php foreach ($player_mil_p_stats as $player_year): ?>
  <tr>
    <td><?php echo $player_year['year']; ?></td>
    <td><?php echo $player_year['age']; ?></td>
    <td><a href="index.php?action=get_roster&team_id=<?php echo $player_year['team_id'];?>&year=<?php echo $player_year['year'];?>"><?php echo $player_year['abbr'] ?></a></td>
    <td><?php echo $player_year['league']; ?></td>
    <td><?php echo round($player_year['war'],1); ?></td>
    <td><?php echo $player_year['k9']; ?></td>
    <td><?php echo $player_year['bb9']; ?></td>
    <td><?php echo $player_year['K/BB']; ?></td>
    <td><?php echo $player_year['HR9']; ?></td>
    <td><?php echo $player_year['WHIP']; ?></td>
    <td><?php echo round($player_year['gb/fb'],3); ?></td>
    <td><?php echo ltrim($player_year['BABIP'],"0"); ?></td>
    <td><?php echo $player_year['FIP']; ?></td>
    <td><?php echo $player_year['xFIP']; ?></td>
    <td><?php echo $player_year['FIPminus']; ?></td>
    <td><?php echo $player_year['ERAminus']; ?></td>
    <td><?php echo $player_year['ERAplus']; ?></td>
  </tr>
<?php endforeach; ?>
</table>
<table>
    <thead>
        Major League Batting Stats
    </thead>
    <th>Year</th><th>Age</th><th>Team</th><th>G</th><th>PA</th><th>AB</th>
    <th>R</th><th>H</th><th>2B</th><th>3B</th><th>HR</th><th>RBI</th>
    <th>SB</th><th>CS</th><th>BB</th><th>SO</th><th>BBRate</th><th>KRate</th><th>BA</th><th>OBP</th>
    <th>OBP+</th><th>wOBA</th><th>SLG</th><th>ISO</th><th>OPS</th><th>WAR</th><th>wRAA</th><th>wRC</th><th>wRC+</th>
    <th>GDP</th><th>HBP</th><th>SH</th><th>SF</th><th>IBB</th>
<?php foreach ($player_ml_b_stats as $player_year) : ?>
  <tr>
    <td><?php echo $player_year['year'] ?></td>
    <td><?php echo $player_year['age'] ?></td>
    <td><a href="index.php?action=get_roster&team_id=<?php echo $player_year['team_id'];?>&year=<?php echo $player_year['year'];?>"><?php echo $player_year['abbr'] ?></a></td>
    <td><?php echo $player_year['g'] ?></td>
    <td><?php echo $player_year['PA'] ?></td>
    <td><?php echo $player_year['ab'] ?></td>
    <td><?php echo $player_year['r'] ?></td>
    <td><?php echo $player_year['h'] ?></td>
    <td><?php echo $player_year['d'] ?></td>
    <td><?php echo $player_year['t'] ?></td>
    <td><?php echo $player_year['hr'] ?></td>
    <td><?php echo $player_year['rbi'] ?></td>
    <td><?php echo $player_year['sb'] ?></td>
    <td><?php echo $player_year['cs'] ?></td>
    <td><?php echo $player_year['bb'] ?></td>
    <td><?php echo $player_year['k'] ?></td>
    <td><?php echo ltrim($player_year['bbrate'],"0") ?></td>
    <td><?php echo ltrim($player_year['krate'],"0") ?></td>
    <td><?php echo ltrim($player_year['ba'],"0") ?></td>
    <td><?php echo ltrim($player_year['obp'],"0") ?></td>
    <td><?php echo $player_year['OBPplus'] ?></td>
    <td><?php echo ltrim($player_year['woba'],"0") ?></td>
    <td><?php echo ltrim($player_year['slg'],"0") ?></td>
    <td><?php echo ltrim($player_year['iso'],"0") ?></td>
    <td><?php echo ltrim($player_year['ops'],"0") ?></td>
    <td><?php echo round($player_year['war'],1) ?></td>
    <td><?php echo $player_year['wRAA'] ?></td>
    <td><?php echo $player_year['wRC'] ?></td>
    <td><?php echo $player_year['wRC+'] ?></td>
    <td><?php echo $player_year['gdp'] ?></td>
    <td><?php echo $player_year['hp'] ?></td>
    <td><?php echo $player_year['sh'] ?></td>
    <td><?php echo $player_year['sf'] ?></td>
    <td><?php echo $player_year['ibb'] ?></td>
  </tr>
<?php endforeach; ?>
</table>

<table>
    <thead>
        Minor League Batting Stats
    </thead>
    <th>Year</th><th>Age</th><th>Team</th><th>G</th><th>PA</th><th>AB</th>
    <th>R</th><th>H</th><th>2B</th><th>3B</th><th>HR</th><th>RBI</th>
    <th>SB</th><th>CS</th><th>BB</th><th>SO</th><th>BBRate</th><th>KRate</th><th>BA</th><th>OBP</th>
    <th>OBP+</th><th>wOBA</th><th>SLG</th><th>ISO</th><th>OPS</th><th>WAR</th><th>wRAA</th><th>wRC</th><th>wRC+</th>
    <th>GDP</th><th>HBP</th><th>SH</th><th>SF</th><th>IBB</th>
<?php foreach ($player_mil_b_stats as $player_year) : ?>
  <tr>
    <td><?php echo $player_year['year'] ?></td>
    <td><?php echo $player_year['age'] ?></td>
    <td><a href="index.php?action=get_roster&team_id=<?php echo $player_year['team_id'];?>&year=<?php echo $player_year['year'];?>"><?php echo $player_year['abbr'] ?></a></td>
    <td><?php echo $player_year['g'] ?></td>
    <td><?php echo $player_year['PA'] ?></td>
    <td><?php echo $player_year['ab'] ?></td>
    <td><?php echo $player_year['r'] ?></td>
    <td><?php echo $player_year['h'] ?></td>
    <td><?php echo $player_year['d'] ?></td>
    <td><?php echo $player_year['t'] ?></td>
    <td><?php echo $player_year['hr'] ?></td>
    <td><?php echo $player_year['rbi'] ?></td>
    <td><?php echo $player_year['sb'] ?></td>
    <td><?php echo $player_year['cs'] ?></td>
    <td><?php echo $player_year['bb'] ?></td>
    <td><?php echo $player_year['k'] ?></td>
    <td><?php echo ltrim($player_year['bbrate'],"0") ?></td>
    <td><?php echo ltrim($player_year['krate'],"0") ?></td>
    <td><?php echo ltrim($player_year['ba'],"0") ?></td>
    <td><?php echo ltrim($player_year['obp'],"0") ?></td>
    <td><?php echo $player_year['OBPplus'] ?></td>
    <td><?php echo ltrim($player_year['woba'],"0") ?></td>
    <td><?php echo ltrim($player_year['slg'],"0") ?></td>
    <td><?php echo ltrim($player_year['iso'],"0") ?></td>
    <td><?php echo ltrim($player_year['ops'],"0") ?></td>
    <td><?php echo round($player_year['war'],1) ?></td>
    <td><?php echo $player_year['wRAA'] ?></td>
    <td><?php echo $player_year['wRC'] ?></td>
    <td><?php echo $player_year['wRC+'] ?></td>
    <td><?php echo $player_year['gdp'] ?></td>
    <td><?php echo $player_year['hp'] ?></td>
    <td><?php echo $player_year['sh'] ?></td>
    <td><?php echo $player_year['sf'] ?></td>
    <td><?php echo $player_year['ibb'] ?></td>
  </tr>
<?php endforeach; ?>
</table>

<table>
  <thead>
    Major League Fielding Stats
  </thead>
  <th>Year</th><th>Age</th><th>Team</th><th>Pos</th><th>G</th><th>GS</th>
  <th>IP</th><th>Opps</th><th>PO</th><th>A</th><th>E</th><th>DP</th><th>PCT</th><th>ZR</th>
  <?php foreach ($player_ml_f_stats as $player_year) : ?>
    <tr>
      <td><?php echo $player_year['year']; ?></td>
      <td><?php echo $player_year['age']; ?></td>
      <td><a href="index.php?action=get_roster&team_id=<?php echo $player_year['team_id'];?>&year=<?php echo $player_year['year'];?>"><?php echo $player_year['abbr'] ?></a></td>
      <td><?php echo $player_year['pos_name']; ?></td>
      <td><?php echo $player_year['g']; ?></td>
      <td><?php echo $player_year['gs']; ?></td>
      <td><?php echo $player_year['ip'].'.'.$player_year['ipf']; ?></td>
      <td><?php echo $player_year['tc']; ?></td>
      <td><?php echo $player_year['po']; ?></td>
      <td><?php echo $player_year['a']; ?></td>
      <td><?php echo $player_year['e']; ?></td>
      <td><?php echo $player_year['dp']; ?></td>
      <td><?php echo round(($player_year['po'] + $player_year['a']) / ($player_year['po'] + $player_year['a'] + $player_year['e']),3); ?></td>
      <td><?php echo round($player_year['zr'],1); ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<table>
  <thead>
    Minor League Fielding Stats
  </thead>
  <th>Year</th><th>Age</th><th>Team</th><th>Pos</th><th>G</th><th>GS</th>
  <th>IP</th><th>Opps</th><th>PO</th><th>A</th><th>E</th><th>DP</th><th>PCT</th><th>ZR</th>
  <?php foreach ($player_mil_f_stats as $player_year) : ?>
    <tr>
      <td><?php echo $player_year['year']; ?></td>
      <td><?php echo $player_year['age']; ?></td>
      <td><a href="index.php?action=get_roster&team_id=<?php echo $player_year['team_id'];?>&year=<?php echo $player_year['year'];?>"><?php echo $player_year['abbr'] ?></a></td>
      <td><?php echo $player_year['pos_name']; ?></td>
      <td><?php echo $player_year['g']; ?></td>
      <td><?php echo $player_year['gs']; ?></td>
      <td><?php echo $player_year['ip'].'.'.$player_year['ipf']; ?></td>
      <td><?php echo $player_year['tc']; ?></td>
      <td><?php echo $player_year['po']; ?></td>
      <td><?php echo $player_year['a']; ?></td>
      <td><?php echo $player_year['e']; ?></td>
      <td><?php echo $player_year['dp']; ?></td>
      <td><?php echo round(($player_year['po'] + $player_year['a']) / ($player_year['po'] + $player_year['a'] + $player_year['e']),3); ?></td>
      <td><?php echo round($player_year['zr'],1); ?></td>
    </tr>
  <?php endforeach; ?>
</table>
<?php include('view/footer.php'); ?>
