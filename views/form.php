<?php
    require_once 'controllers/form_controller.php';

    $nationalities = load_nationalities();
    $countries = load_countries();
    $activities = load_activities();
    $form_result = handle_form_submission();
    $errors = $form_result['errors'];
    $success = $form_result['success'];
    $user_data = $form_result['user_data'];
?>

<?php include 'includes/header.php'; ?>

<?php if (isset($errors['global'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Erreur!</strong>
        <span class="block sm:inline"><?php echo $errors['global']; ?></span>
    </div>
<?php endif; ?>

<form method="POST" class="max-w-lg mx-auto bg-white p-6 rounded-md shadow-md lg:my-8" enctype="multipart/form-data">
    <div class="mb-4">
        <label for="nom" class="block text-gray-700 text-sm font-bold mb-2 lg:text-base">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user_data['nom'] ?? ''); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <?php if (isset($errors['nom'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['nom']; ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <label for="prenom" class="block text-gray-700 text-sm font-bold mb-2 lg:text-base">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user_data['prenom'] ?? ''); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <?php if (isset($errors['prenom'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['prenom']; ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2 lg:text-base">Email :</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <?php if (isset($errors['email'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['email']; ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <label for="age" class="block text-gray-700 text-sm font-bold mb-2 lg:text-base">Âge :</label>
        <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($user_data['age'] ?? ''); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <?php if (isset($errors['age'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['age']; ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2 lg:text-base">Sexe :</label>
        <div class="flex items-center">
            <input type="radio" id="sexe_homme" name="sexe" value="homme" class="mr-2" <?php if (isset($user_data['sexe']) && $user_data['sexe'] === 'homme') echo 'checked'; ?>>
            <label for="sexe_homme" class="mr-4">Homme</label>
            <input type="radio" id="sexe_femme" name="sexe" value="femme" class="mr-2" <?php if (isset($user_data['sexe']) && $user_data['sexe'] === 'femme') echo 'checked'; ?>>
            <label for="sexe_femme">Femme</label>
        </div>
        <?php if (isset($errors['sexe'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['sexe']; ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2 lg:text-base">Adresse Postale :</label>
        <div class="flex space-x-2 mb-2">
            <input type="text" id="adresse_numero" name="adresse_numero" placeholder="Numéro" value="<?php echo htmlspecialchars($user_data['adresse_numero'] ?? ''); ?>" class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <input type="text" id="adresse_rue" name="adresse_rue" placeholder="Rue" value="<?php echo htmlspecialchars($user_data['adresse_rue'] ?? ''); ?>" class="shadow appearance-none border rounded w-3/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <?php if (isset($errors['adresse_numero'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['adresse_numero']; ?></p><?php endif; ?>
        <?php if (isset($errors['adresse_rue'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['adresse_rue']; ?></p><?php endif; ?>
        <div class="flex space-x-2">
            <input type="text" id="adresse_zip" name="adresse_zip" placeholder="Code Postal" value="<?php echo htmlspecialchars($user_data['adresse_zip'] ?? ''); ?>" class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <input type="text" id="adresse_ville" name="adresse_ville" placeholder="Ville" value="<?php echo htmlspecialchars($user_data['adresse_ville'] ?? ''); ?>" class="shadow appearance-none border rounded w-2/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <?php if (isset($errors['adresse_zip'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['adresse_zip']; ?></p><?php endif; ?>
        <?php if (isset($errors['adresse_ville'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['adresse_ville']; ?></p><?php endif; ?>
    </div>

    <div class="mb-4">
        <label for="nationalite" class="block text-gray-700 text-sm font-bold mb-2 lg:text-base">Nationalité :</label>
        <select id="nationalite" name="nationalite" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Sélectionnez une nationalité</option>
            <?php foreach ($nationalities as $nation) : ?>
                <option value="<?php echo htmlspecialchars($nation); ?>" <?php if (isset($user_data['nationalite']) && $user_data['nationalite'] === $nation) echo 'selected'; ?>><?php echo htmlspecialchars($nation); ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['nationalite'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['nationalite']; ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <label for="pays_naissance" class="block text-gray-700 text-sm font-bold mb-2 lg:text-base">Pays de Naissance :</label>
        <select id="pays_naissance" name="pays_naissance" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Sélectionnez un pays</option>
            <?php foreach ($countries as $country) : ?>
                <option value="<?php echo htmlspecialchars($country); ?>" <?php if (isset($user_data['pays_naissance']) && $user_data['pays_naissance'] === $country) echo 'selected'; ?>><?php echo htmlspecialchars($country); ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['pays_naissance'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['pays_naissance']; ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <label for="description" class="block text-gray-700 text-sm font-bold mb-2 lg:text-base">Brève Description (Optionnelle, 978 caractères max):</label>
        <textarea id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500" maxlength="978"><?php echo htmlspecialchars($user_data['description'] ?? ''); ?></textarea>
        <?php if (isset($errors['description'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['description']; ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <label for="loisirs" class="block text-gray-700 text-sm font-bold mb-2 lg:text-base">Loisirs (2 à 4 choix):</label>
        <select multiple id="loisirs" name="loisirs[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500" >
            <?php foreach ($activities as $activity) : ?>
                <option value="<?php echo htmlspecialchars($activity); ?>" <?php if (isset($user_data['loisirs']) && in_array($activity, $user_data['loisirs'])) echo 'selected'; ?>><?php echo htmlspecialchars($activity); ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['loisirs'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['loisirs']; ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <label for="mot_de_passe" class="block text-gray-700 text-sm font-bold mb-2 lg:text-base">Mot de Passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" value="" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <?php if (isset($errors['mot_de_passe'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['mot_de_passe']; ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <label for="confirmation_mot_de_passe" class="block text-gray-700 text-sm font-bold mb-2 lg:text-base">Confirmation Mot de Passe :</label>
        <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" value="" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <?php if (isset($errors['confirmation_mot_de_passe'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['confirmation_mot_de_passe']; ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <label for="avatar" class="block text-gray-700 text-sm font-bold mb-2 lg:text-base">Avatar (Optionnel - PNG, JPEG, GIF):</label>
        <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg, image/gif" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <?php if (isset($errors['avatar'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['avatar']; ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <div class="flex items-center">
            <input type="checkbox" id="consentement" name="consentement" class="mr-2" <?php if (isset($_POST['consentement'])) echo 'checked'; ?>>
            <label for="consentement" class="text-gray-700 text-sm font-bold lg:text-base">J'accepte le traitement des données pour un usage interne et non commercial.</label>
        </div>
        <?php if (isset($errors['consentement'])): ?>
            <p class="text-red-500 text-xs italic font-semibold"><?php echo $errors['consentement']; ?></p>
        <?php endif; ?>
    </div>

    <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500 transition-colors duration-300" type="submit">
            S'inscrire
        </button>
    </div>
</form>

<?php include 'includes/footer.php'; ?>