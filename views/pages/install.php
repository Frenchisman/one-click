<p>Saisir infos</p>
<?php
	if(isset($form_errors)){
		if(isset($form_errors['empty']) ){
			echo "<p>Veuillez remplir tous les champs requis.</p>";
		}
		else if(isset($form_errors['connection'])){
			echo "<p>Impossible de se connecter a la base de données avec les informations fournies, veuillez les vérifier.</p>";
		}
	}
 ?>
<form action="?controller=install&action=validate" method="post">
	<div>
		<label for="db_name">
		Nom de la base de données 
		</label>

		<input type="text" id="db_name" name="db_name" placeholder="<?=$ini['db_name']?>" required>
	</div>
	<div>
		<label for="db_user">
			Identifiant 
		</label>
		<input type="text" id="db_user" name="db_user" placeholder="<?=$ini['db_user']?>" required>
	</div>
	<div>
		<label for="db_password">
			Mot de passe 
		</label>
		<input type="password" id="db_password" name="db_password" placeholder="<?=$ini['db_password']?>" required>
	</div>
	<div>
		<label for="db_host">
			Adresse de la base de données 
		</label>
		<input type="text" id="db_host" name="db_host" placeholder="<?=$ini['db_host']?>" required>
	</div>
	<div>
		<label for="table_prefix">
			Préfixe des tables
		</label>
		<input type="text" id="table_prefix" name="table_prefix" placeholder="<?=$ini['table_prefix']?>" required>
	</div>
	<div class="button">
		<button type="submit">
			Valider
		</button>
	</div>
</form>