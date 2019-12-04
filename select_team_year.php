<?php include 'view/header.php'; ?>
<br>
<section>
<div class="left">

<aside>
  <h2>Choose Your League</h2>
<ul>

  <?php foreach ($leagues as $league) : ?>
  <li><a href="?league_id=<?php echo $league['league_id'] ?>">
        <?php echo $league['name']; ?></a>
  </li>
<?php endforeach; ?>
  </ul>
</aside>


  <h2>Select Your Year and League</h2>
  <br>
  <form class="" action="index.php" method="get">
    <input type="hidden" name="action" value="get_roster">
    <label>Year:</label>
    <select class="" name="year">
      <option selected disabled></option>
      <?php foreach ($years as $year) : ?>
        <option value="<?php echo $year['year']; ?>">
          <?php echo $year['year']; ?>
        </option>
      <?php endforeach; ?>
    </select>


    <label>Teams:</label>
    <select class="" name="team_id">
      <option selected disabled>Please Choose</option>
    <?php foreach ($teams as $team): ?>
      <option value="<?php echo $team['team_id'] ?>">
      <?php echo $team['city']." ".$team['nickname']; ?>
    </option>
  <?php endforeach; ?>
    </select>
    <input type="submit" name="" value="Select">
  </form>


<br>

<?php include 'view/footer.php'; ?>
