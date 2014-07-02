<?
//William Cruz
//06/19/2014
//PHP with HTML: Superglobals and Uploading Files
//Refactoring code with filestore

//var_dump($_GET);
//var_dump($_POST);
//var_dump($_FILES);

require_once('classes/fileStore.php');
$book = new Filestore('list.txt');
$list = $book->read();
    // Verify there were uploaded files and no errors
    if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0 && $_FILES['file1']['type'] == 'text/plain') {
    // Set the destination directory for uploads
        $upload_dir = '/vagrant/sites/todo.dev/public/list.txt';
    // Grab the filename from the uploaded file by using basename
        $filename = basename($_FILES['file1']['name']);
        // Create the saved filename using the file's original name and our upload directory
        $saved_filename = $upload_dir . $filename;
    // Move the file from the temp location to our uploads directory
        move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
        $upload = new Filestore($saved_filename);
        $new_upload_file = $upload->read();
        $list = array_merge($list, $new_upload_file);
        $book->write($list);
    } else {
        echo "File not valid type. Please enter a plain text file.";
    }
        
    if (isset($_GET['id'])){
        unset($list[$_GET['id']]);
        $book->write($list);
    }

    if (!empty($_POST['todo_item'])) {
        $NewTodo = $_POST['todo_item'];
        $list[] = $NewTodo;
        $book->write($list);    
    }
    
    if (isset($saved_filename)) {
        // If we did, show a link to the uploaded file
            echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
        // Check if we saved a file
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
            echo "<ul>";
            foreach ($list as $key => $value) {
                echo "<li><span class='value'>$value</span> | <a href ='?id=$key'>Mark Complete</a></li> ";
            }
            echo "</ul>";
            ?>

        <form method="POST">
            <p>
                <label for="todo_item">Enter Something Todo:</label>
                <input id="todo_item" name="todo_item" type="text">
                <input type="submit" value="Submit">
            </p>
        </form>
        <h2>Upload File</h2>
        <form method="POST" enctype="multipart/form-data" action="tdl.php">
            <p>
                <label for="file1">File to upload: </label>
                <input type="file" id="file1" name="file1">
            </p>
            <p>
                <input type="submit" value="Upload">
            </p>
        </form>
    </body>
</html>
