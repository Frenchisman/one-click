<p>Informations nécessaires</p>
<?php
	if(isset($form_errors)){
		if(isset($form_errors['empty']) ){
			echo "<p>Veuillez remplir tous les champs requis.</p>";
		}
		else if(isset($form_errors['creation'])){
			echo "<p>Erreur lors de la création des tables.</p>";
		}
	}
 ?>
<form action="?controller=install&action=create" method="post">
	<div>
		<label for="user_id">
		Nom d'Utilisateur
		</label>

		<input type="text" id="user_id" name="user_id" placeholder="admin" required>
	</div>
	<div>
		<label for="password">
			Mot de Passe 
		</label>
		<input type="text" id="password" name="password" required>
		<p><strong>Important :</strong>Vous aurez besoin de ce mot de passe pour vous connecter. Pensez a le stocker dans un lieu sur.</p>
	</div>
	
	<div class="button">
		<button type="submit">
			Installer
		</button>
	</div>
</form>