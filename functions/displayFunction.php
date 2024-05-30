<?php
function displayServices($result, $numServices, $listType, $title, $isSearch)
{

    if ($isSearch) {
        echo '
        <section id="searchPage">
        <br><br>
            <form action="search.php" method="post" > 
                <div class="InputContainer">
                    <input placeholder="Search.." id="input" class="input" name="search" type="text" required>
                </div><br><br>
            </form>    
    ';
    }else {
        echo "<section id='" . $listType . "'><br>";
    }    
    echo "
            <h1>" . $title . "</h1>
        <br>";
    $myArray = [];
    $i = 0;
    echo '<ul>';
    if ($result->num_rows > 0) {
        while (($row = $result->fetch_assoc()) && $i < $numServices) {
            $sid = $row["service_ID"];
            $tit = $row["title"];
            $descr = $row["description"];
            $na = $row["name"];
            if (!in_array($sid, $myArray)) {
?>
                <p>
                <form method="post" action="servicePag.php">
<?php
                $imgName = $row["img_name"];
                $myArray[] = $sid;
                echo "<a href='servicePag.php?value=" . $sid . "' class='styleFora'><li>
                <img class='img" . $listType . "Container' src='img/" . $imgName . "' />
                <h3 class='headerOfParagraphFontFor" . $listType . "'>" . $tit . "</h3><p class='paragraphFont" . $listType . "'>" . $descr . "</p>
                <p class='paragraphFont" . $listType . "'>Service provider: " . $na . "</p></li></a></form>";
                $i++;
            }
        }
    } else {
        echo "No results found.";
    }
    echo '</ul><br>
    </section>';
} ?>