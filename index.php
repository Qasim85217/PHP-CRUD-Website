<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "notes";
$conn = mysqli_connect($servername, $username, $password, $dbname);
$insert = false;
$update = false;
$delete = false;
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $sql = "DELETE FROM `notes` WHERE `notes`.`SNO` = $sno";
    $result = mysqli_query($conn, $sql);
    $delete = true;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoedit'])) {
        $title = $_POST['modalinputtitle'];
        $desc = $_POST['modalinputdesc'];
        $sno = $_POST['snoedit'];
        $sql = "UPDATE `notes` SET `title` = '$title' , `Desc` = '$desc' WHERE `notes`.`sno` = $sno";
        $result = mysqli_query($conn, $sql);
        $update = true;
    } else {
        $title = $_POST['title'];
        $desc = $_POST['describtion'];
        $sql = "INSERT INTO `notes` (`SNO`, `Title`, `Desc`, `date`) VALUES (NULL,'$title', '$desc', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $insert = true;
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discuss</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">


</head>

<body>
    <header>
        <div id="navimg">
            <img src="./discuss.jpg">
        </div>
        <nav>

            <div id="navul">
                <ul>
                    <li> <a href="./index.php" style="background-color: #ff3b3b;">Home</a></li>
                    <li> <a href="./about.html">About</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <section>
        <?php
        if ($insert == true) {
            echo '<div id="main-prompt">
            <div id="prompt">
                <p>
                    <b>Successfully!</b>Your note has inserted successfully.
                </p>
                <button onclick="display_prompt()">&times; </button>
            </div>
        </div>';
        }
        if ($update == true) {
            echo '<div id="main-prompt">
            <div id="prompt">
                <p>
                    <b>Successfully!</b>Your note has updated successfully.
                </p>
                <button onclick="display_prompt()">&times; </button>
            </div>
        </div>';
        }
        if ($delete == true) {
            echo '<div id="main-prompt">
            <div id="prompt">
                <p>
                    <b>Successfully!</b>Your note has deleted successfully.
                </p>
                <button onclick="display_prompt()">&times; </button>
            </div>
        </div>';
        }
        ?>

        <h1>Add a Note</h1>
        <hr>
        <div id="form">
            
            <form action="/phpwork/CRUD_operation/index.php" method="post"  onsubmit="return post_note()">
                <div>
                    <h3>Write Title</h3>
                </div>
                <div id="titlediv"><input type="text" id="noteinputtitle" class="inputtitle" name="title" minlength="10"
                        maxlength="124" onclick="rules_post()" ><p id="warned_title"></p></div>
                <div>
                    <h3>Write Describtion</h3>
                </div>
                <div id="descdiv"><textarea id="noteinputdesc" class="inputdesc" name="describtion" minlength="10"
                        maxlength="354" onclick="rules_post()" ></textarea><p id="warned_desc"></p>
                </div>
                <div id="instruction_para" ><a  href="./about.html#rules_post" >Please follow to rule before posting.By clicking here.</a></div>
                <div><input type="submit" id="submitnote" value="Add Note"></div>
            </form>
        </div>
        <hr>
        <div id="modal">
            <div id="modal-back"></div>
            <div id="edit-modal">
                <form action="/phpwork/CRUD_operation/index.php?update=true" method="post">
                    <div class="close-modal-btn"><label for="modal-button" class="close-modal"
                            onclick="closeeditmodal()">&times;</label></div>
                    <input type="hidden" name="snoedit" id="snoedit">
                    <h2>Edit Note</h2>
                    <hr>
                    <div id="modal-titlediv"><label for="modalinputtitle">Title</label><input type="text"
                            id="modalinputtitle" class="inputtitle" name="modalinputtitle"></div>
                    <div id="modal-descdiv"><label for="inputdesc">Describtion</label><textarea id="modalinputdesc"
                            class="inputdesc" name="modalinputdesc"></textarea></div>
                    <div id="modal-update-button"><input type="submit" value="Update"></div>
                </form>
            </div>
            <div id="delete-modal">
                <div class="close-modal-btn"><label for="modal-button" class="close-modal"
                        onclick="closedeletemodal()">&times;</label></div>
                <hr>
                <p>Are you want to delete it? </p>
                <hr>
                <div id="delete-modal-button">
                    <button id="delete-yes" onclick="deleterow()">Yes</button>
                    <button onclick="closedeletemodal()">No</button>
                </div>
            </div>
        </div>
        <div class="searcharea">
            <div class="sortno">
                <button onclick="sort_arrow_Button1()" class="sort-arrow-btn">&lt</button>
                <button onclick="sort_arrow_Button2()" class="sort-arrow-btn">&gt</button>
            </div>
            <div>
                <p>Search:</p>
                <input type="text" id="searchbox" name="search" placeholder="Searchbox" onkeyup="searchTable()">
            </div>
        </div>
        <div id="Notelist">
            <table id="mytable">
                <thead>
                    <tr class="notelistrow">
                        <th id="notesno" class="snolist">S No</th>
                        <th id="notetitle">Title</th>
                        <th id="notedesc">Describtion</th>
                        <th id="actionnote">Add Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `notes`";
                    $result = mysqli_query($conn, $sql);
                    $sno = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sno = $sno + 1;
                        echo ' <tr class="notelistrow"> <td>' . $sno . '</td><td>' . $row["Title"] . '</td><td>' . $row["Desc"] . '</td><td><button onclick="openeditmodal()" id=' . $row['SNO'] . '  class="editbutton">Edit</button><button onclick="opendeletemodal()" id=' . $row['SNO'] . ' class="deletebutton">Delete</button></td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        </div>
        <footer>
            <div>
                <a href="https://github.com/Qasim85217" target="_blank"><img
                        src="https://github.githubassets.com/assets/GitHub-Mark-ea2971cee799.png"></a>
                <a href="https://www.linkedin.com/in/muhammad-qasim-524025259/" target="_blank"><img
                        src="https://cdn-icons-png.flaticon.com/128/121/121509.png"></a>
            </div>
            <p>Copyright &#169 2023-2024.All Right Reversed</p>
            <p>Designed By:Muhammad Qasim</p>
        </footer>
    </section>
    <script src="./script.js"></script>
    <script>
        var edit = document.querySelectorAll(".editbutton")
        edit.forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode
                title = tr.querySelectorAll("td")[1].innerText; // Corrected selection of title
                desc = tr.querySelectorAll("td")[2].innerText; // Corrected selection of description
                sno = e.target.id;
                snoedit = document.querySelector('#snoedit')
                snoedit.value = sno
                titleedit = title;
                descedit = desc;

                editmodaltitle = document.querySelector("#modalinputtitle");
                editmodaldesc = document.querySelector("#modalinputdesc");


                editmodaltitle.value = titleedit;
                editmodaldesc.value = descedit;
            });
        });
        var deletebutton = document.querySelectorAll(".deletebutton")
        deletebutton.forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode
                sno = e.target.id
                delete_yes = document.querySelector("#delete-yes")
                delete_yes.addEventListener("click", () => {
                    window.location = `/phpwork/CRUD_operation/index.php?delete=${sno}`;
                })
            })
        })


    </script>
</body>


</html>