<?php include 'view/header.php'; ?>
<br><br><br>

<div class="team_home_header">


<h2><?php echo $team_info['name']." ".$team_info['nickname'] ; ?></h2>
<img src="<?php echo $team_logo_path; ?>" class="logo">

</div>

<table>
  <caption>Current Year Record</caption>
  <thead>
    <th>G</th><th>W</th><th>L</th><th>PCT</th><th>POS</th><th>GB</th><th>Magic</th>
  </thead>
  <?php foreach ($current_record as $record) : ?>
  <tr>
    <td><?php echo $record['g']; ?></td>
    <td><?php echo $record['w']; ?></td>
    <td><?php echo $record['l']; ?></td>
    <td><?php echo $record['pct']; ?></td>
    <td><?php echo $record['pos']; ?></td>
    <td><?php echo $record['gb']; ?></td>
    <td><?php echo $record['magic_number']; ?></td>
  </tr>
<?php endforeach; ?>
</table>
<br><br>
<table>
  <caption>Historical Record</caption>
  <thead>
    <th>Year</th><th>G</th><th>W</th><th>L</th><th>PCT</th><th>GB</th>
  </thead>
  <?php foreach ($historical_record as $team_year) : ?>

  <tr>
    <td><?php echo $team_year['year']; ?></td>
    <td><?php echo $team_year['g']; ?></td>
    <td><?php echo $team_year['w']; ?></td>
    <td><?php echo $team_year['l']; ?></td>
    <td><?php echo ltrim(round($team_year['pct'],3),"0"); ?></td>
    <td><?php echo $team_year['pos']; ?></td>
    <td><?php echo $team_year['gb']; ?></td>
  </tr>

<?php endforeach; ?>
</table>

<?php include 'view/footer.php'; ?>
