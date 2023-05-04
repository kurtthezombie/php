<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="css/w3.css">
</head>
<body bgcolor="white" class="w3-margin-left w3-margin-right">
    <h1 style="color: red; font-family: Roboto;">Blood Donation Camp</h1><br><br>
    <button class="w3-button w3-red" onclick="add_btn()">+ADD</button><br><br>
    <table class="w3-table-all">
        <tr>
            <?php 
                include "helper.php";
                createHeader();
            ?>
        </tr>
        <tr>
            <?php 
                $users = getRecords();
                foreach($users as $user): 
            ?>
                <tr>
                    <?php foreach($user as $key=>$value): ?>
                        <td><?php echo ($value); ?></td>
                    <?php endforeach; ?>
                    <td>
                        <button name="del-btn" onclick="delete_donor(<?= $user['id'] ?>)">&times;</button>
                        <button name="edit-btn" onclick="update_donor(
                            <?php echo $user['id']; ?>,'<?=$user['name']?>','<?=$user['email']?>','<?=$user['phone']?>','<?=$user['bgroup']?>'
                        )">&#9998;</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tr>
    </table>    
    <div class="w3-modal" id="modal">
        <div class="w3-modal-content">
            <div class="w3-container w3-red">
                <h3>Blood Donor</h3>
                <button class="w3-button w3-display-topright"
                onclick="
                    document.getElementById('modal').style.display='none';
                    resetForm();
                ">&times;</button>
            </div>
            <div class="w3-container">
                <form action="helper.php" method="POST" id="myForm">
                    <input type="hidden" value="0" name="flag">
                    <input type="hidden" value="<?= $user['id']?>" name="id">
                    <p>
                        <label for="user">NAME: </label>
                        <input class="w3-input w3-border" type="text" name="name" id="name" required>
                    </p>
                    <p>
                        <label for="email">EMAIL: </label>
                        <input class="w3-input w3-border" type="text" name="email" id="email" required>
                    </p>
                    <p>
                        <label for="phone">PHONE: </label>
                        <input class="w3-input w3-border" type="text" name="phone" id="phone" required>
                    </p>
                    <p>
                        <label for="bgroup">BLOOD GROUP: </label>
                        <select class="w3-select w3-border" name="bgroup" id="bgroup">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </p>
                    <input class="w3-right w3-button w3-red w3-margin-bottom" type="submit" name="save-btn" value="&#128427;SAVE" id="save-btn">
                </form>
            </div>
        </div>
    </div>
    <script>
        function delete_donor(id) {
            var ok = confirm("Delete this donor? =>"+id)
            if (ok) {
                var formData = new FormData();
                formData.append('id',id);
                formData.append('del-btn',true);
                
                fetch('helper.php', {
                    method: 'POST',
                    body: formData
                })
                .then(function(response){
                    if(response.ok){
                        location.reload();
                    }
                })
                .catch(function(error){
                    console.error(error);
                });
            }
        }
        function add_btn() {
            flag = document.getElementsByName("flag")[0].value=0;
            document.getElementById('modal').style.display ='block';
            clearForm();
            document.getElementsByName("name")[0].focus();

        }
        
        function clearForm() {
            var form = document.getElementById("myForm"); // replace "myForm" with the ID of your form
            var elements = form.elements;
            for (var i = 0; i < elements.length; i++) {
                var element = elements[i];
                if (element.type === "select-one") {
                    element.selectedIndex = -1;
                } else if (element.type !== "submit") {
                    element.value = "";
                }
            }
        }

        function update_donor(id,name,email,phone,bgroup) {
            flag = document.getElementsByName("flag")[0].value=1;
            document.getElementsByName("name")[0].value=name;
            document.getElementsByName("email")[0].value=email;
            document.getElementsByName("phone")[0].value=phone;
            document.getElementsByName("bgroup")[0].value=bgroup;
            document.getElementById('modal').style.display='block';
            document.getElementsByName("name")[0].focus();
            console.log(flag);
            console.log(document.getElementsByName("id")[0]);
        }
    </script>
</body>
</html>