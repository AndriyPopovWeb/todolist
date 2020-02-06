<?php

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $task =[
      "id"        => $_POST['id'],
      "name"      => $_POST['name'],
      "date"      => $_POST['date'],
      "priority"  => $_POST['priority'],
    ];

    $sql = "UPDATE todotable 
            SET id = :id,
              name = :name,
              date = :date,
              priority = :priority
            WHERE id = :id";
  
  $statement = $connection->prepare($sql);
  $statement->execute($task);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
  
if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM todotable WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    
    $task = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<blockquote><?php echo escape($_POST['firstname']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit a task</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="id">Id</label>
    <input type="text" name="id" id="id" value="<?php echo escape($task['id']); ?>" readonly>
    <label for="name">Name</label>
    <input type="text" name="name" id="name" value="<?php echo escape($task['name']); ?>">
    <label for="date">Date</label>
    <input type="date" name="date" id="date" value="<?php echo date('Y-m-d',strtotime($task["date"])) ?>">
    <label for="priority">Priority</label>
    <input type="number" name="priority" id="priority" value="<?php echo escape($task['priority']); ?>">
    <input type="submit" name="submit" value="Submit">
</form>

<?php require "templates/footer.php"; ?>
