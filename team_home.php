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
    <td><?php echo round(ltrim($record['pct'],"0"),3); ?></td>
    <td><?php echo $record['pos']; ?></td>
    <td><?php echo $record['gb']; ?></td>
    <td><?php echo $record['magic_number']; ?></td>
  </tr>
<?php endforeach; ?>
</table>
<br><br>

<?php  echo "<table><caption>Historical Record</caption><thead><th>Year</th><th>G</th><th>W</th><th>L</th><th>PCT</th><th>Pos</th><th>GB</th>
      </thead>"; ?>
<?php foreach ($team_historical_record as $year) {
   echo "<tr>";
    echo "<td><a href=\"index.php?action=get_roster&team_id="
      .$year['team_id']."&year=".$year['year']."\">"
    .$year['year']."</a></td>
         <td>".$year['g']."</td>
         <td>".$year['w']."</td>
         <td>".$year['l']."</td>
         <td>".ltrim($year['pct'],"0")."</td>
         <td>".$year['pos']."</td>
         <td>".$year['gb']."</td>";
    echo "</tr>";
  }
  echo "</table>";
  ?>



<?php include 'view/footer.php'; ?>
