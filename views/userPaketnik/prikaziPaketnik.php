<h2><?php echo $paketnik->name; ?></h2>
<div style="margin: 0 20px">
<p>ID paketnika: <?php echo $paketnik->paketnikId; ?></p>
<?php
    if($paketnik->isOwner == "1") {
        echo "<p>Lastnik paketnika</p>";
    }
    else {
        echo "<p>Paketnik v posoji</p>";
    }
    if ($paketnik->accessTill == "9999-12-31 23:59:59") {
        echo "<p>Neomejen dostop</p>";
    }
    else {
        $date = new DateTime($paketnik->accessTill);
        echo "<p>Dostop do: " . date_format($date, 'd.m.Y H:i:s') . "</p>";
    }
?>
<a href="index.php"><button class="btn btn-primary">Nazaj</button></a>

<button class="btn btn-primary" type="button" name="changeName" onclick="onButtonClick()">Spremeni ime</button>
<button class="btn btn-primary" type="button" name="deletePaketnik" onclick="onButtonClickDelete(<?php echo $_SESSION["USER_ID"] ?>, <?php echo $paketnik->paketnikId ?>)">Izbriši paketnik</button>
<?php if ($paketnik->isOwner == "1") { ?>
    <button class="btn btn-primary" type="button" name="posodiKljuc" onclick="onButtonClickPrikaziPosodiKljuc()">Posodi ključ</button>
<?php } ?>

<div class="hide" id="hidden">
    <br />
    <input type="text" id="textInput" value="" />
    <button class="btn btn-primary" type="button" id="btn" onclick="changeName()">Shrani</button>
</div>

<div class="hide" id="hiddenPosodiKljuc">
    <br />
    <form action="?controller=userPaketnik&action=posodiKljuc" method="post">
        <div class="form-group">
            <input type="hidden" name="paketnikId" value="<?php echo $paketnik->paketnikId ?>" />
            <input type="hidden" name="redirectId" value="<?php echo $paketnik->id ?>" />
            <input type="hidden" name="name" value="<?php echo $paketnik->name ?>" />
            <label for="username">Uporabniško ime:</label>
            <input type="text" class="form-control" required="required" name="username" placeholder="Uporabniško ime" /> <br />
            <label for="accessTill">Dostop do:</label>
            <input type="date" id="accessTill" name="accessTill"
                   value="<?php $tomorrow = new DateTime('tomorrow'); echo $tomorrow->format('Y-m-d'); ?>"
                   min="<?php echo $tomorrow->format('Y-m-d'); ?>" max="9999-12-31">
            <br/>
            <br/>
            <button class="btn btn-primary" type="submit" name="Dodaj">Potrdi</button>
        </div>
    </form>
</div>
<br />
</div>
<style>
    .hide{
        display:none;
    }
    .show{
        display:block;
    }
</style>
<script>
    function onButtonClick() {
        document.getElementById('hidden').className="show";
    }

    async function changeName() {
        var name = document.getElementById("textInput").value;
        var userId = <?php echo $_SESSION["USER_ID"] ?>;
        var paketnikId = <?php echo $paketnik->paketnikId ?>;
        let url = 'https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/uporabnikPaketnik/spremeniIme/' + <?php echo $_SESSION["USER_ID"] ?> + "/" + <?php echo $paketnik->paketnikId ?> + "/" + name;
        console.log(url);
        try {
            let res = await fetch(url);
            return await res.json();
        } catch (error) {
            window.location = 'index.php', true;
            console.log(error);
        }
        document.location.reload(true);
    }
    function onButtonClickDelete(userId, paketnikId) {
        deletePaketnik(userId, paketnikId);
    }

    async function deletePaketnik(userId, paketnikId) {
        let url = 'https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/uporabnikPaketnik/izbrisi/' + userId + "/" + paketnikId;
        console.log(url);
        try {
            let res = await fetch(url);
            return await res.json();

        } catch (error) {
            window.location = 'index.php', true;
            console.log(error);
        }
    }

    function onButtonClickPrikaziPosodiKljuc() {
        document.getElementById('hiddenPosodiKljuc').className="show";
    }

</script>
<hr />


<br />
<div style="width: 50%; height: 50%; background-color: ; float:left;">
    <h3>Zgodovina odklepov</h3>
<?php
echo "<div style='margin: 0 20px'>";
foreach ($zgodovina as $data) {
    $date = new DateTime($data->date);
    echo "<p>" . $date->format('d.m.Y H:m:s') . "</p>";
}
echo "</div>"
?>
</div>
<div style="width: 50%; height: 50%; background-color: ; float:right;">
    <h3>Posojenci ključa</h3>
    <?php
    echo "<div style='margin: 0 20px'>";
    foreach ($borrowed as $data) {
        echo "<p style='font-size:20px'>Ime uporabnika:  $data->name</p>"; ?>
        <button class="btn btn-primary" type="button" name="odvzamiDostop" onclick="onButtonClickDelete(<?php echo $data->userId ?>, <?php echo $paketnik->paketnikId ?>)">Odvzami dostop</button>
        <?php echo "<br /><br />";
    }
    echo "</div>"
    ?>
</div>
