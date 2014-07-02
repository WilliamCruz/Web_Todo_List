<?
//William Cruz
//5/28/14
//PHP with HTML: Superglobals and Uploading Files

$filename = 'list.txt';
$list = [];
$list = open_file($filename);

function save_file($filename, $list)
    {
        $list_string = implode("\n", $list);
        $handle = fopen($filename, 'w');
        fwrite($handle, $list_string);
        fclose($handle); 
    }
function open_file($filename) 
    {
        $filesize = filesize($filename);
        $handle = fopen($filename, "r");
        $list_string = trim(fread($handle, $filesize));
        $list_array = explode("\n", $list_string);
        fclose($handle);
        return $list_array;
    }
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
        $newfile = open_file($saved_filename);
        $list = array_merge($list, $newfile);
        save_file($filename, $list);

    }
    if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0 && $_FILES['file1']['type'] == 'text/plain') {
        echo "File not valid type. Please enter a plain text file. ";
    }       

    if (isset($_GET['id'])){
        unset($list[$_GET['id']]);
        save_file($filename, $list);
    }

    if (!empty($_POST['todo_item'])) {
        $NewTodo = $_POST['todo_item'];
        $list[] = $NewTodo;
        save_file($filename, $list);    
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
        echo "<li>$value | <a href ='?id=$key'>Mark Complete </a></li> ";
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
