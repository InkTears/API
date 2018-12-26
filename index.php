<!doctype html>
<html lang="fr">
<head>
    <title>API</title>
    <link rel="stylesheet" href="style.css">
    <script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
<div class="container">
    <table id="userTable" border="1" >
        <thead>
        <tr>
            <th width="5%">ID</th>
            <th width="25%">Name</th>
            <th width="25%">Email</th>
            <th width="25%">Action</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<form>
    Nom : <input type="text" name="name"><br>
   Email : <input type="email" name="email"><br>
    <input name="submit" type="submit" value="Submit">
</form>

</body>
</html>