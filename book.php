<?php

include 'header.php';

 if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     $first_name = $_SESSION["first_name"];
     $last_name = $_SESSION["last_name"];
     $phone = $_SESSION["phone"];
 }

include 'DB.php';
$sql = "SELECT * FROM services";
$result = $conn->query($sql);
 ?>


<body>
    

    <div class="reg_success">
        <div class="success">
            
        </div>
    </div>
    <div class="container">
    <div class="callback">
            <div class="callback_left">
                <div class="left_item">
                    <p class="item_title">забронювати</p>
                    <p class="item_textb">Будь ласка, заповніть форму бронювання і найближчим часом з Вами зв’яжеться адміністратор для підтвердження бронювання</p>
                    <p class="item_texts">Забронювати студію можна за телефоном</p>
                    <div class="phone"><a href="tel:+38(097)7777777">+38 (097) 777 77 77</a></div>
                    <p class="item_text">Або за допомогою форми бронювання</p>
                    <p class="item_textm">Бронюючи студію Ви погоджуєтесь з правилами оренди студії!
                       <br><span class="ytext item_textb">Важливо!</span> Закінченням оренди студії вважається час, коли орендар <span class="item_textb">залишає студію, а не закінчує зйомку!</span> 
                       <br>Будь ласка, розраховуйте час заздалегідь! 
                       <br>Мінімальний час оренди студії – 2 години!</p>
                </div>
            </div>
            <div class="callback_right">
                <div class="forms">
                    <div id="contact-wrapper">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="contactform">
                            <div class="form">
                                <label for="surname"><strong>Прізвище:</strong></label>
                                <input type="text" class="required" size="50" name="surname" id="surname" value="<?php echo $last_name?>" />
                            </div>
                            <div class="form">
                                <label for="contactname"><strong>Ім'я:</strong></label>
                                <input type="text" class="required" size="50" name="contactname" id="contactname" value="<?php echo $first_name?>" />
                            </div>
                            <div class="form">
                                <label for="phone"><strong>Телефон:</strong></label>
                                <input type="text" class="required" size="50" name="phone" id="phone" value="<?php echo $phone?>" />
                            </div>
                            <div class="form">
                                <label><strong>Послуга</strong></label>
                                <select style="height: 50px; margin: 10px 0 10px 0" id="service" name="service">
                                    <?php  while($row = $result->fetch_assoc()): ?>
                                        <option value="<?php echo $row['id']?>"><?php echo $row['name']?></option>
                                    <?php endwhile;?>
                                </select>
                            </div>
                            <div class="form">
                                <label for="message"><strong>Коментар:</strong></label>
                                <textarea rows="5" cols="50" name="message" id="message"></textarea>
                            </div>

                            <input class="submit" type="submit" value="Забронювати" name="submit" />
                        </form>
                    </div>                       
                </div>
            </div>
        </div>
    </div>

</body>




<?php

include 'footer.php';

include 'DB.php';

if (isset($_POST["submit"]) &&
    isset($_POST["surname"]) &&
    isset($_POST["contactname"]) &&
    isset($_POST["phone"])&&
    isset($_POST["service"]))
    {
        $sql = "INSERT INTO books (surname, name, phone, comment, service_id)
        VALUES ('".$_POST['surname']."', '".$_POST['contactname']."', '".$_POST['phone']."', '".$_POST['message']."', '".$_POST['service']."')";

        if ($conn->query($sql) === TRUE) {
            echo "Вас зареєстровано";
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
          
          $conn->close();
    }
?>