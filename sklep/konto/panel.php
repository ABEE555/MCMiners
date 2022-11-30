<?php
session_start();
if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header('location:./index.php');
}
require("../../backrooms/bd-authorize.php");
if(isset($_POST['edit'])){
    $userid = $_POST['ID'];
    $nick = $_POST['nick'];
    $email = $_POST['email'];
    if(isset($_POST['status'])){
        $admin = 1;
    } else {
        $admin = 0;
    }
    if(!empty($nick) && !empty($email) && !empty($userid)){
        $stmt = $pdo->exec('UPDATE klienci SET `nick` = "'.$nick.'", `email` = "'.$email.'", `admin` = "'.$admin.'" WHERE `id_klienta` LIKE '.$userid);
    }
    header('location:panel-users.php');
} elseif(isset($_POST['remove'])){
    $userid = $_POST['ID'];
    if(!empty($userid)){
        $stmt = $pdo->exec('UPDATE klienci SET `email` = "NULL", `haslo` = "NULL" WHERE `id_klienta` LIKE '.$userid); // Usuwanie nie powinno całkowicie wymazywać użytkownika z bazy danych bo musi zostać w historii tranzakcji
    }
    header('location:panel-users.php');
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MinersMC</title>
    <link rel="icon" type="image/png" href="../../resources/logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta&family=Nunito:wght@200;300;400&family=Work+Sans&display=swap" rel="stylesheet">


    <style>
           body{
            background: repeat url("../../resources/bg2.png");
            color: white;
            position: relative;
        }
        h1, h5{
            font-family: 'Work Sans', sans-serif;
        }
        .separator{
            margin: 25px 0;
            background-color: white;
            border: 0;
            height: 2px;
        }
        .btn-outline-primary{
            color:white;
            border-color:#00FF7F;
            margin:5px;
            box-shadow:2px 2px 3px #000, inset 2px 2px 3px #000;
            border-width: 3px;
        }
        .btn-outline-primary:hover{
            box-shadow: 2px 2px 3px #000, inset 0px 0px 0px #000;
            border-color:#00FF7F;
            background-color:#00FF7F;
            color: black;
        }
        .navbar-dark .navbar-nav .nav-link{
            font-family: 'Nunito', sans-serif;
            font-size: 22px;
            color: white;
        }
        .navbar-dark{
            background: repeat url("../../resources/dirt.jpg");
        }
        .nav-item{
            margin-right:50px;
        }
        .scrolled-down{
            transform:translateY(-100%); transition: all 0.3s ease-in-out;
        }
        .scrolled-up{
            transform:translateY(0); transition: all 0.3s ease-in-out;
        }
        .btn:focus{
            box-shadow: 0 0 0 .25rem rgba(0, 179, 89,.5) !important;
        }
        .btn:active{
            background-color: #00b359;
            border-color: #00FF7F;
        }
        .btn-primary{
            background-color:#00FF7F;
            color:black;
            border: none;
        }
        .btn-primary:hover{
            background-color:#00b359;
            color:black;
            border: none;
        }
        .btn-primary:focus{
            background-color:#00b359;
        }
        .btn-secondary{
            background-color:#444;
            color:white;
            border: none;
        }
        .invis{
            background-color: rgba(0, 0, 0, 0);
            border: none;
        }
        .modal-header{
            color: white;
            background: repeat url("../../resources/dirt.jpg");
        }
        .modal-body{
            color: white;
            background-color: #333;
        }
        .modal-footer{
            background: repeat url("../../resources/dirt.jpg");
        }
        .big-btn svg{
            color: #00FF7F;
        }
        .big-btn:hover svg{
            color:#00b359;
            width: 105px;
            height: 105px;
            transition: 0.3s;
        }
        .big-btn:active svg{
            color:#00b359;
            width: 95px;
            height: 95px;
            transition: 0.2s;
        }
        .box-shadow{
            -webkit-box-shadow: 5px 5px 0px 0px rgba(39, 39, 42, 1);
            -moz-box-shadow: 5px 5px 0px 0px rgba(39, 39, 42, 1);
            box-shadow: 5px 5px 0px 0px rgba(39, 39, 42, 1);
        }
        table{
            text-align: center;
            width: 100%;
            margin-top: 30px;
        }
        td{
            min-width: fit-content;
            width: 20%;
        }
        tr:hover{
            background-color: #42445A;
            color: #00FF7F;
            transition: 0.3s;
        }
        .searchpanel{
            margin: auto;
            display: block;
            width: 90%;
            text-align: center;
        }
        .searchpanel input{
            min-width: 150px;
        }
        .welcomediv{
            max-width: 50%;
            margin: auto;
        }
        .welcome{
            margin: 20px auto 20px auto;
            text-align: center;
            display: block;
        }
    </style>
    </style>

</head>
<body data-bs-spy="scroll" data-bs-target="#navigacja">

<div class="container-fluid">
    <nav class="navbar autohide fixed-top navbar-dark navbar-expand-md justify-content-center">
        <div class="container">
            <a href=".." class="navbar-brand d-flex w-50 me-auto"><img src="../../resources/logo.png" style="height:50px;" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsingNavbar3">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse w-100" id="collapsingNavbar3">
                <ul class="navbar-nav w-100 justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="..">Powrót</a>
                    </li>
                    <li class="nav-item">
                        <form method="post">
                            <button type="submit" name="logout" class="invis">
                                <a class="nav-link" >Wyloguj się</a>
                            </button>
                        </form>
                    </li>
                </ul>
                <div class="nav navbar-nav ms-auto w-100"></div>
            </div>
        </div>
    </nav>

    <div class="welcomediv">
        <?php
        $time = time();
        try{
            $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->query('SELECT nick FROM klienci WHERE id_klienta LIKE "'.$_SESSION['user'].'"');
            foreach ($stmt as $row) {
                if(date('H', $time) > 18 || date('H', $time) < 5) {
                    echo "<h1 class='welcome'>Dobry wieczór, " . $row['nick'] . "</h1>";
                } else {
                    echo "<h1 class='welcome'>Dzień dobry, " . $row['nick'] . "</h1>";
                }
                echo "<img src='https://minotar.net/helm/".$row['nick']."/100.png' class='welcome box-shadow' />";
            }
            $stmt->closeCursor();
        } catch(PDOException $e) {
            echo '😵';
        }
        ?>
    </div>
    <div class="separator"></div>

    <div class='panel-grid'>
        <?php
                try{
                    $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $pdo->query('SELECT * FROM klienci WHERE id_klienta LIKE "'.$_SESSION['user'].'"');
                    foreach ($stmt as $row) {

                        echo "<a class='big-btn box-shadow' onclick='edit(".$row['id_klienta'].")' data-bs-toggle='modal' data-bs-target='#userForm'>";
//czemu to nie dziala????
                    }
                    $stmt->closeCursor();
                } catch(PDOException $e) {
                    echo '😵';
                }
                ?>
                 <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-chat-right-quote-fill" viewBox="0 0 16 16">
                <path d="M16 2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h9.586a1 1 0 0 1 .707.293l2.853 2.853a.5.5 0 0 0 .854-.353V2zM7.194 4.766c.087.124.163.26.227.401.428.948.393 2.377-.942 3.706a.446.446 0 0 1-.612.01.405.405 0 0 1-.011-.59c.419-.416.672-.831.809-1.22-.269.165-.588.26-.93.26C4.775 7.333 4 6.587 4 5.667 4 4.747 4.776 4 5.734 4c.271 0 .528.06.756.166l.008.004c.169.07.327.182.469.324.085.083.161.174.227.272zM11 7.073c-.269.165-.588.26-.93.26-.958 0-1.735-.746-1.735-1.666 0-.92.777-1.667 1.734-1.667.271 0 .528.06.756.166l.008.004c.17.07.327.182.469.324.085.083.161.174.227.272.087.124.164.26.228.401.428.948.392 2.377-.942 3.706a.446.446 0 0 1-.613.01.405.405 0 0 1-.011-.59c.42-.416.672-.831.81-1.22z"></path>
            </svg>
        </a>
            </div>
            <div class="modal fade" id="userForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Dodawanie klienta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input value="" disabled="true" name="ID" id="userFormID" style="display:none">
                        <input class="form-control mt-3" type="text" maxlength="48" name="nick" id="userFormNick" placeholder="Nick" required>
                        <input class="form-control mt-3" type="email" maxlength="64" name="email" id="userFormEmail" placeholder="E-mail" required>
                        <input class="form-control mt-3" type="password" name="pwd" id="userFormPwd" maxlength="30" placeholder="Hasło" required>
                        <input class="mt-3" type="checkbox" name="status" id="userFormAdmin" checked="false">
                        Admin
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button id="confirmRemove" name="remove" type="submit" class="btn btn-primary" style="display:none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm2.121.707a1 1 0 0 0-1.414 0L4.16 7.547l5.293 5.293 4.633-4.633a1 1 0 0 0 0-1.414l-3.879-3.879zM8.746 13.547 3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z"/>
                            </svg>
                            Usuń
                        </button>
                        <button id="confirmEdit" name="edit" type="submit" class="btn btn-primary" style="display:none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                            Zapisz
                        </button>
                </form>
            </div>
        </div>
    </div>
    </div>

    
    <div style="text-align:center;color:white;">Wdrożenie - AM 2022</div>
</div>
<script>
    var title = document.getElementById("gridtitle");
    var names = ["Użytkownicy","Promocje","Produkty","Zamówienia","Dodaj wpis","Wszystkie wpisy"];
    var elements = document.getElementsByClassName("big-btn");

    for(let i = 0; i < elements.length; i++){
        elements[i].addEventListener('mouseenter', function(){
           title.innerText = names[i];
        });
        elements[i].addEventListener('mouseleave', function(){
            title.innerText = "";
        });
    }
</script>
<script>
    var title = document.getElementById("modalTitle");
    var ID = document.getElementById("userFormID");
    var Nick = document.getElementById("userFormNick");
    var Email = document.getElementById("userFormEmail");
    var Pwd = document.getElementById("userFormPwd");
    var isAdmin = document.getElementById("userFormAdmin");
    var addbutton = document.getElementById("confirmAddNew");
    var editbutton = document.getElementById("confirmEdit");
    var deletebutton = document.getElementById("confirmRemove");
    
    function edit(id){
        title.innerText = "Edycja klienta";
        addbutton.style.display = "none";
        $id =$_SESSION['user'];
        ID.disabled = false;
        Nick.value = document.getElementById("user" + id).children[2].innerText;
        Email.value = document.getElementById("user" + id).children[3].innerText;
        Pwd.disabled = true;
        Pwd.value = "N/A";
        if(document.getElementById("user" + id).children[4].innerText == "Admin"){
            isAdmin.checked = true;
            deletebutton.style.display = "none";
        } else {
            isAdmin.checked = false;
            deletebutton.style.display = "block";
        }
        if(document.getElementById("user" + id).children[3].innerText == "NULL"){
            editbutton.style.display = "none";
            deletebutton.style.display = "none";
        } else {
            editbutton.style.display = "block";
        }
    }
</script>
<script src="../../resources/scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
