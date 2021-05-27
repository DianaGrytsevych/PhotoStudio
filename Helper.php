<?php
class Helper{
    public static function permission($username, $part){
        include 'DB.php';
        $sql = 'SELECT name FROM permissions INNER JOIN users ON users.role_id = permissions.role_id WHERE username = "'.$username.'"';
        $result = $conn->query($sql);
        $flag = 0;
        while ($row = $result->fetch_assoc()){
            if($row['name'] == $part){
                $flag = 1;
                break;
            }
        }
        $conn->close();
        return $flag;
    }
    public static function redirect($url)
    {
        $string = '<script type="text/javascript">';
        $string .= 'window.location = "' . $url . '"';
        $string .= '</script>';

        echo $string;
    }
    public static function error($text){
        echo '<p style="font-family: Montserrat, sans-serif; text-align: center; vertical-align: middle; line-height: 590px;"><strong>Error: '.$text.'</strong></p>';
    }
}