<h1>Leaderboards Home</h1>

<h3>Team All Time Leaders</h3>
<h5>Select a League, then click "Choose League". Then Select your team and stat.</h5>
<form class="" action="index.php" method="get">
<input type="hidden" name="action" value="team">
<label for="league_id">Select League:</label>
  <select class="" name="league_id">
      <option selected disabled>Choose League</option>
    <?php foreach ($leagues as $league) : ?>
      <option value="<?php echo $league['league_id']; ?>">
      <?php echo $league['name']; ?></option>
    <?php endforeach; ?>
  </select>
<input type="submit" value="Select League">
</form>

<h5>Once you've selected your League, select your team and sorting stat.</h5>
<form class="" action="index.php" method="get">
  <input type="hidden" name="action" value="team">
  <label>Teams:</label>
  <select class="" name="team_id">
    <option selected disabled>Choose Team</option>
  <?php foreach ($teams as $team): ?>
    <option value="<?php echo $team['team_id'] ?>">
    <?php echo $team['city']." ".$team['nickname']; ?>
  </option>
<?php endforeach; ?>
  </select>
  <label for="stat">Sorting Stat:</label>
  <select class="" name="stat">
    <option selected disabled></option>
    <?php foreach ($b_stat_names as $stat) : ?>
      <option value="<?php echo $stat ;?>"><?php echo $stat; ?></option>
    <?php endforeach; ?>
  </select>
  <input type="submit" value="Select">
</form>
