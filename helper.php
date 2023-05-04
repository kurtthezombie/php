<?php 
    $header_list = array('id','name','email','phone','bgroup', 'action');
    $table = 'users';

    if(isset($_POST['save-btn'])) {
        main();
    }
    
    /*if(isset($_POST['save-btn'])) {
        $conn = connect();
        $last_id = mysqli_insert_id($conn);

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $bgroup = $_POST['bgroup'];
        $userData = array(
            'id' => isset($_POST['id']) ? $_POST['id'] : '',
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'bgroup' => $_POST['bgroup']
        );
        $flag = isset($_POST['flag']) ? intval($_POST['flag']) : 0;
        var_dump($flag);

        saveRecord($userData, $flag);
        mysqli_close($conn);
        header('Location: index.php');
    }*/
    function main(){
        $conn = connect();
        echo "id: ".$_POST['id'];
        $id = $_POST['id'];
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $bgroup = isset($_POST['bgroup']) ? $_POST['bgroup'] : '';
        $userData = array(
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'bgroup' => $bgroup
        );
        echo $userData['id'];
        echo $userData['name'];
        echo $userData['email'];
        echo $userData['phone'];
        echo $userData['bgroup'];
        $flag = isset($_POST['flag']) ? intval($_POST['flag']) : 0;
        var_dump($flag);

        saveRecord($userData,$flag);
        mysqli_close($conn);
        header('Location: index.php'); 
        
    }
    if(isset($_POST['del-btn'])) {
        $id = $_POST['id'];
        deleteRecord($id);
        mysqli_close(connect());
        header('Location: index.php');
    }

    function connect(){
        $conn = mysqli_connect('localhost', 'root', '', 'test1') or die("Connection Failed: ".mysqli_connect_error());
        return $conn;    
    }

    function createHeader() {
        global $header_list;
        foreach ($header_list as $header) {
            echo "<th>" . strtoupper($header) . "</th>";
        }
    }

    function getRecords() {
        global $table;
        $data = array();
        $sql = "SELECT * FROM `$table`";
        $conn = connect();
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }
    
    function saveRecord($userData, $flag) {
        var_dump($flag);
        if($flag == 1){
            echo "Updating Record...";
            updateRecord($userData);
        } else{
            echo "Deleting Record...";
            addRecord($userData);
        }     
    }

    function addRecord($userData) {
        global $table;
        $name = $userData[array_keys($userData)[1]];
        $email = $userData[array_keys($userData)[2]];
        $phone = $userData[array_keys($userData)[3]];
        $bgroup = $userData[array_keys($userData)[4]];
        $sql = "INSERT INTO `$table`(`name`,`email`,`phone`,`bgroup`) 
        VALUES ('$name','$email','$phone','$bgroup');";
        $conn = connect();
        $result = mysqli_query($conn,$sql);
        if($result) {
            echo "Blood Donor added...";
        }
    }

    function updateRecord($userData) {
        global $table;
        $id = $userData[array_keys($userData)[0]];
        $keys = array_keys($userData);
        $values = array_values($userData);
        $flds = array();
        for ($i = 1; $i < count($values); $i++) {
            $flds[] = "`".$keys[$i]."`='".$values[$i]."'";
        }
        $fields = implode(',',$flds);
        $sql = "UPDATE `".$table."` SET ".$fields." WHERE `id` = ".$id;
        echo $sql;
        $conn = connect();
        $result = mysqli_query($conn,$sql);
        if($result) {
            echo "Blood Donor updated...";
        }
    }

    function deleteRecord($id) {
        global $table;
        $sql = "DELETE FROM `$table` WHERE `id`=$id";
        $conn = connect();
        $result = mysqli_query($conn,$sql);
    }
?>