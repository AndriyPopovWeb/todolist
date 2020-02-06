<?php

require "../config.php";
require "../common.php";

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM todotable";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
        
<table>
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Date</th>
        <th>Priority</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><?php echo escape($row["id"]); ?></td>
        <td><?php echo escape($row["name"]); ?></td>
        <td><?php echo escape($row["date"]); ?></td>
        <td><?php echo escape($row["priority"]); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

<?php require "templates/footer.php"; ?>