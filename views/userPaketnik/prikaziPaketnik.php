<h1><?php echo $paketnik->name; ?></h1>
<p>ID paketnika: <?php echo $paketnik->paketnikId; ?></p>

<p>Dostop do: <?php echo $paketnik->accessTill; ?></p>
<a href="index.php"><button>Nazaj</button></a>

<input type="button" name="changeName" value="Spremeni ime" onclick="onButtonClick()" />
<div class="hide" id="hidden">
    <br />
    <input type="text" id="textInput" value="" />
    <input type="button" id="btn" value="Shrani" onclick="changeName()" />

</div>
<input class="hide" type="text" id="userId" value="<?php echo $_SESSION["USER_ID"] ?>" />
<input class="hide" type="text" id="paketnikId" value="<?php echo $paketnik->paketnikId ?>" />

<br />
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
            var userId = document.getElementById("userId").value;
            var paketnikId = document.getElementById("paketnikId").value;
            let url = 'https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/uporabnikPaketnik/spremeniIme/' + userId + "/" + paketnikId + "/" + name;
            console.log(url);
            try {
                let res = await fetch(url);
                return await res.json();
            } catch (error) {
                console.log(error);
            }
        }
</script>
<hr />