<?php
//William Cruz
//6-24-14
//PHP with MYSQL - TODO List

// Exercises:
// Create a database, and a table to hold your TODOs.
// Update TODO list application to use MySQL instead of flat files.
// Be sure to use prepared statements for all queries that could contain user input.
// Add pagination. This should display 10 results per page, and when your list has over 
// 10 records, there should be buttons to allow you to navigate forward and backwards through the "pages" of todos.
// Abstract the MySQL connection and reusable functions to a class, if applicable.

//created new todo database in mysql pro
$dbc = new PDO('mysql:host=127.0.0.1;dbname=todo_db', 'william', 'vitzma_16');
// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// //created table
// $query = 'CREATE TABLE todo_item (
// 	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
// 	item VARCHAR(50) NOT NULL,
// 	PRIMARY KEY (id)
// )';
// $dbc->exec($query);


//$query = 'SELECT * FROM todo_item';
//$stmt =$dbc->prepare("SELECT * FROM todo_item");
$todo_db = $dbc->query('SELECT * FROM todo_item')->fetchAll(PDO::FETCH_ASSOC);

$count = $dbc->query('SELECT count(*) FROM todo_item')->fetchColumn();
// $stmt->execute();

if (!empty($_POST)) {

	if (!empty($_POST['remove'])) {
		// delete query statements
		$stmt =$dbc->prepare("DELETE FROM todo_db(item) WHERE id = ?;");
		$stmt->bindValue(':item', $_POST['remove'], PDO::PARAM_STR);
		$stmt->execute(array($todo_item));
		//ensure remove functionality

	} else {
		$stmt =$dbc->prepare("INSERT INTO todo_item (item) VALUES (:item)");
		$stmt->bindValue(':item', $_POST['item'], PDO::PARAM_STR);
		// execute
		$stmt->execute();
		header('Location:http://todo.dev/todo_list_db.php');
		// save_file($filename, $list);
	}
}


?>

<!DOCTYPE>
<html>
<head>
	<title>Todo List</title>
 	<link rel="stylesheet" type="text/css" href="stylesheet.css" />
 </head>
 <body>
 	<h2>Todo List</h2>
<?

// echo "<ul>";

// foreach ($todo_db as $item) {
// 	foreach ($item as $key => $value) {
// 		echo "<p>$key - $value</p>";
// 	}
// }

// foreach ($list as $key => $value) {
// 	echo "<li>$value | ";
// 	echo '<button class="btn btn-danger btn-sm pull-right btn-remove"data-todo="' . $key . '">Remove</button>';
// }
// echo "</ul>";
?> 

<table>

	<tr>
		<th>ID</th>
		<th>Item</th>
		<th>Remove</th>
	</tr>

	<tr>
		<?php foreach ($todo_db as $item): ?>
			<?php foreach ($item as $key => $value): ?>
				<?= "<td>$value</td>"?>
			<?php endforeach ?>
			<!-- <td><button class=\"btn btn-danger btn-sm pull-right btn-remove\" data-todo=\"////\">Remove</button></td></tr> -->
			<td> <button class="btn btn-danger btn-sm pull-right btn-remove"data-todo="<?= $item['id']; ?>">Remove</button></td></tr>
		<?php endforeach ?>
	</tr>

</table>

<form id="removeForm" action="todo_list_db.php" method="POST">
	<input id="removeId" type="hidden" name="remove" value="">
</form>
	<h2>Upload File</h2>
 <form method="POST" enctype="multipart/form-data" action="todo_list_db.php">

  <p>
	<label for="item">Enter Something Todo:</label>
	<input id="item" name="item" type="text">
	<input type="submit" value="Submit">
  </p>
    <p>
       <label for="file1">File to upload: </label>
       <input type="file" id="file1" name="file1">
   </p>
  	<p>
      <input type="submit" value="Upload">
    </p>
   </form>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
   <script>

$('.btn-remove').click(function () {
    var todoId = $(this).data('todo');
    if (confirm('Are you sure you want to remove item ' + todoId + '?')) {
        $('#removeId').val(todoId);
        $('#removeForm').submit();
    }
});
</script>
   </body>
</html>


 



