<p>REGISTRACIJA</p>

<form action="?controller=user&action=shrani" method="post">
    <div class="form-group">
        <label for="username">Uporabniško ime:</label>
        <input type="text" class="form-control" required="required" name="username" placeholder="Username" />
        <label for="password">Geslo:</label>
        <input type ="password" name="password" required="required" class="form-control" placeholder="Password" />
        <label for="email">Email:</label>
        <input type="text" class="form-control" required="required" name="email" placeholder="Email" />
        <label for="name">Datum rojstva:</label>
        <input type="date" class="form-control" required="required" name="birthDate" placeholder="birthDate" />
        <br/>
        <input class="btn btn-primary" type="submit" name="Dodaj" value="Potrdi"/>
    </div>
</form>