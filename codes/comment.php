<?php
    // JS function to cancel edit
    echo "<script>
    function cancelEdit(){
        var form = document.getElementsByName('editform');
        form.remove();
    }</script>";

    // Function to Create comments
    function submitComment($conn){
        if (isset($_POST['commentSubmit'])){
            $comment = $_POST['comment'];
            $date = $_POST['date'];
            $email = $_SESSION['email'];
            $gameid = $_POST['GameID'];
            if (empty($comment)){
                echo "Please fill in the comment";
            }
            else{
                $comment = sanitize_input($comment);
                $sql = $conn->prepare("INSERT INTO Comments (Comment, Date, Com_Email, Com_GameID) VALUES (?, ?, ?, ?)");
                $sql->execute([$comment, $date, $email, $gameid]);
            }
        }
    }

    // Function to Delete comments
    function deleteComments($conn){
        if (isset($_POST['comment-delete'])){
            $cid = $_POST['cid'];
            $sql = $conn->prepare("DELETE FROM Comments WHERE Cid = ?");
            $sql->execute([$cid]);
        }
    }

    // Function to Edit comments
    function editComment($conn){
        $commentName = $_POST['comment-edit'];
        $cid = $_POST['cid'];
        if (isset($_POST['comment-edit']) && $commentName == "comment-edit-".$cid){
            $id = $_POST['gameid'];
            $stmt = $conn->prepare("SELECT * FROM Comments WHERE Cid = :cid"); // Prepare the statement
            $stmt->bindParam(':cid', $cid, PDO::PARAM_INT); // Bind the parameter
            $stmt->execute(); // Execute the statement
            $stmt->setFetchMode(PDO::FETCH_ASSOC); // Get the result
            $row = $stmt->fetch(); // Fetch the data
            $comment = $row['Comment'];
            
            if ($commentName == "comment-edit-".$cid){
                echo "<form name = 'editform' method='POST' action='updateComment.php'>
                        <label>Edit comment here:<br><textarea name='editedComment'>" . $comment . "</textarea></label>
                        <input type='hidden' name='cid' value='" . $cid . "'>
                        <input type='hidden' name='date' value='" . date('Y-m-d') . "'>
                        <input type=hidden name='gameid' value='". $id . "'>
                        <button type='submit' name='updatenow'>Update</button>
                        <button type='submit' name='cancel' onclick='cancelEdit()'>Cancel</button>
                    </form>";
            }
        }
    }

    // Function to Sanitize comments
    function sanitize_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>