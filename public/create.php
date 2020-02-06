<?php

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
      "name"      => $_POST['name'],
      "priority"  => $_POST['priority'],
      "date"      => $_POST['date']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "todotable",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['firstname']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Create</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="name">Name</label>
    <input type="text" name="name" id="name">
    <label for="date">Date</label>
    <input type="date" name="date" id="date">
    <label for="priority">Priority</label>
    <input type="number" name="priority" id="priority">
    <input type="submit" name="submit" value="Submit">
  </form>

<?php require "templates/footer.php"; ?>