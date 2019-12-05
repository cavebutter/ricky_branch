<?php include 'view/header.php'; ?>
<br><br><br>

<div class="roster_head" >
  <div class="team_name">

      <h1><?php echo $year.'  -  '.$combined_name; ?></h1>

  </div>
  <div class="logo">
    <a href="index.php?action=team_home&team_id=<?php echo $team_name['team_id']; ?>">
      <img src="<?php echo $team_logo_path; ?>" alt="<?php echo $combined_name; ?>"> </a>
  </div>
  <div class="record">
    <table>
      <thead>

      </thead>
      <th>W</th><th>L</th><th>PCT</th>,<th>POS</th><th>GB</th>
      <?php foreach ($team_record as $item) : ?>
      <tr>
        <td><?php echo $item['w']; ?></td>
        <td><?php echo $item['l']; ?></td>
        <td><?php echo ltrim(round($item['pct'],3),"0"); ?></td>
        <td><?php echo $item['pos']; ?></td>
        <td><?php echo $item['gb']; ?></td>
      </tr>
    <?php endforeach; ?>
      </table>
  </div>
  <div class="b_ba">
    <table>
      <thead>
        Batting Average
      </thead>
      <th>Player</th><th>Avg</th>
      <?php foreach ($team_ba_leaders as $player) : ?>
        <tr>
          <td><a href="index.php?action=get_player&player_id=<?php echo $player['player_id'];?>">
          <?php echo $player['player']; ?></a></td>
          <td><?php echo ltrim($player['ba'],"0") ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
  <div class="b_war">
    <table>
      <thead>
        WAR
      </thead>
      <th>Player</th><th>WAR</th>
      <?php foreach ($team_war_leaders as $player) : ?>
        <tr>
          <td><a href="index.php?action=get_player&player_id=<?php echo $player['player_id'];?>">
          <?php echo $player['player']; ?></a></td>
            <td><?php echo $player['war'] ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
  <div class="b_woba">
    <table>
      <thead>
        wOBA
      </thead>
      <th>Player</th> <th>wOBA</th>
      <?php foreach ($team_woba_leaders as $player) : ?>
        <tr>
          <td><a href="index.php?action=get_player&player_id=<?php echo $player['player_id'];?>">
          <?php echo $player['player']; ?></a></td>
          <td><?php echo ltrim($player['woba'],"0"); ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
  <div class="p_whip">
    <table>
      <thead>
      WHIP
      </thead>
      <th>Player</th><th>WHIP</th>
      <?php foreach ($team_whip_leaders as $player) : ?>
        <tr>
          <td><a href="index.php?action=get_player&player_id=<?php echo $player['player_id'];?>">
          <?php echo $player['player']; ?></a></td>
          <td><?php echo ltrim($player['whip'],"0") ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
  <div class="p_war">
    <table>
      <thead>
        WAR
      </thead>
      <th>Player</th><th>WAR</th>
      <?php foreach ($team_p_war_leaders as $player) : ?>
        <tr>
          <td><a href="index.php?action=get_player&player_id=<?php echo $player['player_id'];?>">
          <?php echo $player['player']; ?></a></td>
            <td><?php echo $player['war'] ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
  <div class="p_fipm">
    <table>
      <thead>
        FIP-
      </thead>
      <th>Player</th> <th>FIP-</th>
      <?php foreach ($team_fipm_leaders as $player) : ?>
        <tr>
          <td><a href="index.php?action=get_player&player_id=<?php echo $player['player_id'];?>">
          <?php echo $player['player']; ?></a></td>
          <td><?php echo ltrim($player['FIPminus'],"0"); ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>
<br><br><br>
<div class="roster">

<table class="fixed_headers">
  <caption>Batters</caption>
  <thead>
    <th>&nbsp;</th><th>Player</th><th>POS</th><th>G</th><th>PA</th><th>AB</th><th>H</th><th>2B</th>
    <th>3B</th><th>HR</th><th>BB</th><th>SO</th><th>BB%</th><th>K%</th><th>BA</th>
    <th>OBP</th><th>SLG</th><th>OPS</th><th>OBP+</th><th>ISO</th><th>BABIP</th><th>wOBA</th>
    <th>wRAA</th><th>wRC</th><th>wRC+</th>
  </thead>
  <tbody>

  <?php foreach ($batters as $batter) : ?>
    <tr>
      <td><img src="<?php echo 'images/person_pictures/player_'.$batter['player_id'].'.png'; ?>"
        alt="<?php echo $batter['player'] ?>"> </td>
      <td><a href="index.php?action=get_player&player_id=<?php echo $batter['player_id']; ?>">
        <?php echo $batter['player']; ?></a></td>
      <td><?php echo $batter['pos']; ?></td>
      <td><?php echo $batter['g']; ?></td>
      <td><?php echo $batter['pa']; ?></td>
      <td><?php echo $batter['ab']; ?></td>
      <td><?php echo $batter['h']; ?></td>
      <td><?php echo $batter['d']; ?></td>
      <td><?php echo $batter['t']; ?></td>
      <td><?php echo $batter['hr']; ?></td>
      <td><?php echo $batter['bb']; ?></td>
      <td><?php echo $batter['k']; ?></td>
      <td><?php echo ltrim($batter['bbrate'],"0"); ?></td>
      <td><?php echo ltrim($batter['krate'],"0"); ?></td>
      <td><?php echo ltrim($batter['ba'],"0"); ?></td>
      <td><?php echo ltrim($batter['obp'],"0"); ?></td>
      <td><?php echo ltrim($batter['slg'],"0"); ?></td>
      <td><?php echo ltrim($batter['ops'],"0"); ?></td>
      <td><?php echo $batter['OBPplus']; ?></td>
      <td><?php echo ltrim($batter['iso'],"0"); ?></td>
      <td><?php echo ltrim($batter['babip'],"0"); ?></td>
      <td><?php echo ltrim($batter['woba'],"0"); ?></td>
      <td><?php echo $batter['wRAA']; ?></td>
      <td><?php echo $batter['wRC']; ?></td>
      <td><?php echo $batter['wRC+']; ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<br><br><br>
<table>
  <thead>
    Pitchers
  </thead>
  <th>&nbsp;</th><th>Player</th><th>G</th><th>GS</th><th>IP</th><th>AB</th><th>HA</th><th>K</th>
  <th>BB</th><th>BF</th><th>WAR</th><th>K9</th><th>BB9</th><th>HR9</th><th>WHIP</th>
  <th>K/BB</th><th>BABIP</th><th>ERA</th><th>FIP</th><th>xFIP</th><th>ERA-</th><th>ERA+</th>
  <th>FIP-</th>
  <?php foreach ($pitchers as $pitcher) : ?>
    <tr>
      <td><img src="<?php echo 'images/person_pictures/player_'.$pitcher['player_id'].'.png'; ?>"
        alt="<?php echo $pitcher['player'] ?>"> </td>
      <td><a href="index.php?action=get_player&player_id=<?php echo $pitcher['player_id']; ?>">
          <?php echo $pitcher['player']; ?></a></td>
      <td><?php echo $pitcher['g']; ?></td>
      <td><?php echo $pitcher['gs']; ?></td>
      <td><?php echo $pitcher['ip']; ?></td>
      <td><?php echo $pitcher['ab']; ?></td>
      <td><?php echo $pitcher['ha']; ?></td>
      <td><?php echo $pitcher['K']; ?></td>
      <td><?php echo $pitcher['bb']; ?></td>
      <td><?php echo $pitcher['bf']; ?></td>
      <td><?php echo round($pitcher['war'],1); ?></td>
      <td><?php echo $pitcher['k9']; ?></td>
      <td><?php echo $pitcher['bb9']; ?></td>
      <td><?php echo $pitcher['HR9']; ?></td>
      <td><?php echo ltrim($pitcher['WHIP'],"0"); ?></td>
      <td><?php echo ltrim($pitcher['K/BB'],"0"); ?></td>
      <td><?php echo ltrim($pitcher['BABIP'],"0"); ?></td>
      <td><?php echo $pitcher['ERA']; ?></td>
      <td><?php echo $pitcher['FIP']; ?></td>
      <td><?php echo $pitcher['xFIP']; ?></td>
      <td><?php echo $pitcher['ERAminus']; ?></td>
      <td><?php echo $pitcher['ERAplus']; ?></td>
      <td><?php echo $pitcher['FIPminus']; ?></td>
    </tr>
  <?php endforeach; ?>
</table>

</div>

<?php include 'view/footer.php'; ?>
