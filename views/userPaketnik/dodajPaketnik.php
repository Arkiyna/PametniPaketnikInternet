<h2>Dodaj paketnik</h2>
<div style="margin: 0 20px">
    <form action="?controller=userPaketnik&action=dodajPaketnik" method="post">
        <div class="form-group">
            <label for="paketnikId">ID paketnika:</label>
            <input type="text" class="form-control" required="required" name="paketnikId" placeholder="ID Paketnika" />
            <label for="nickname">Ime paketnika:</label>
            <input type="text" class="form-control" required="required" name="nickname" placeholder="Ime paketnika" />
            <br/>
            <input class="btn btn-primary" type="submit" name="Dodaj" value="Potrdi"/>
        </div>
    </form>
</div>