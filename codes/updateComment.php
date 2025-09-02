<?php
    require_once "inc/databaseFunctions.php";
    $conn = ConnectToDatabase_pdo();

    if (!$conn){
        echo "Connection failed: ". $conn->connect_error;
    } else {
        if (isset($_POST['updatenow'])){  
            $id = $_POST['gameid'];
            $cid = $_POST['cid'];
            $editedComment = $_POST['editedComment'];
            $date = $_POST['date'];

            try{
                $editedComment = sanitize_input($editedComment);
                $result = $conn->prepare("UPDATE Comments SET Comment =?, Date =? WHERE Cid =?");
                $result->execute([$editedComment, $date, $cid]);
                if ($result){
                    // Pop up message to show that the comment has been updated
                    echo "<script>alert('Comment updated successfully');</script>";
                    echo "<script>window.location.href = 'itempage.php?id=$id';</script>";
                    exit();
                }
            }catch(Exception $e){
                echo "<script>alert('Error: ". $e->getMessage()."');</script>";
            }
            header("Location: itempage.php?id=".$id);
        }
        else if (isset($_POST['cancel'])){
            $id = $_POST['gameid'];
            header("Location: itempage.php?id=".$id);
            // Remove the form
            echo "<script>
                var form = document.getElementsByName('editform');
                form.remove();
            </script>";
            
        }

        
    }

    function sanitize_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>