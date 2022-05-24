<p>DODAJ PAKETNIK</p>

<form action="?controller=userPaketnik&action=dodajPaketnik" method="post">
    <div class="form-group">
        <label for="paketnikId">ID PAKETNIKA:</label>
        <input type="text" class="form-control" required="required" name="paketnikId" placeholder="ID Paketnika" />
        <label for="nickname">IME ZA PAKETNIK:</label>
        <input type="text" class="form-control" required="required" name="nickname" placeholder="Ime paketnika" />
        <br/>
        <input class="btn btn-primary" type="submit" name="Dodaj" value="Potrdi"/>
    </div>
</form>