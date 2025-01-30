<?php

function load_nationalities() {
    $nationalities = [];
    $file = fopen('data/nationality.csv', 'r');
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $nationalities[] = trim($line);
        }
        fclose($file);
    }
    return $nationalities;
}

function load_countries() {
    $countries = [];
    $file = fopen('data/pays.csv', 'r');
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $countries[] = trim($line);
        }
        fclose($file);
    }
    return $countries;
}

function load_activities() {
    $activities = [];
    $file = fopen('data/activity.txt', 'r');
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $activities[] = trim($line);
        }
        fclose($file);
    }
    return $activities;
}

function handle_form_submission() {
    $errors = [];
    $success = false;
    $user_data = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize and retrieve data
        $nom = htmlspecialchars($_POST['nom'] ?? '');
        $prenom = htmlspecialchars($_POST['prenom'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $age = filter_var($_POST['age'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $sexe = htmlspecialchars($_POST['sexe'] ?? '');
        $adresse_numero = htmlspecialchars($_POST['adresse_numero'] ?? '');
        $adresse_rue = htmlspecialchars($_POST['adresse_rue'] ?? '');
        $adresse_zip = htmlspecialchars($_POST['adresse_zip'] ?? '');
        $adresse_ville = htmlspecialchars($_POST['adresse_ville'] ?? '');
        $nationalite = htmlspecialchars($_POST['nationalite'] ?? '');
        $pays_naissance = htmlspecialchars($_POST['pays_naissance'] ?? '');
        $description = htmlspecialchars($_POST['description'] ?? '');
        $loisirs = $_POST['loisirs'] ?? [];
        $mot_de_passe = $_POST['mot_de_passe'] ?? '';
        $confirmation_mot_de_passe = $_POST['confirmation_mot_de_passe'] ?? '';
        $consentement = isset($_POST['consentement']);

        $user_data = [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'age' => $age,
            'sexe' => $sexe,
            'adresse_numero' => $adresse_numero,
            'adresse_rue' => $adresse_rue,
            'adresse_zip' => $adresse_zip,
            'adresse_ville' => $adresse_ville,
            'nationalite' => $nationalite,
            'pays_naissance' => $pays_naissance,
            'description' => $description,
            'loisirs' => $loisirs,
            'consentement' => $consentement,
            'avatar' => '' // Initialize avatar field
        ];

        // Validations
        if (empty($nom)) $errors['nom'] = 'Le nom est obligatoire.';
        if (empty($prenom)) $errors['prenom'] = 'Le prénom est obligatoire.';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'L\'email est obligatoire et doit être valide.';
        if (empty($age) || !is_numeric($age)) $errors['age'] = 'L\'âge est obligatoire et doit être un nombre.';
        if (empty($sexe)) $errors['sexe'] = 'Le sexe est obligatoire.';
        if (empty($adresse_numero)) $errors['adresse_numero'] = 'Le numéro de rue est obligatoire.';
        if (empty($adresse_rue)) $errors['adresse_rue'] = 'Le nom de rue est obligatoire.';
        if (empty($adresse_zip)) $errors['adresse_zip'] = 'Le code postal est obligatoire.';
        if (empty($adresse_ville)) $errors['adresse_ville'] = 'La ville est obligatoire.';
        if (empty($nationalite)) $errors['nationalite'] = 'La nationalité est obligatoire.';
        if (empty($pays_naissance)) $errors['pays_naissance'] = 'Le pays de naissance est obligatoire.';
        if (empty($mot_de_passe)) $errors['mot_de_passe'] = 'Le mot de passe est obligatoire.';
        if (empty($confirmation_mot_de_passe)) $errors['confirmation_mot_de_passe'] = 'La confirmation du mot de passe est obligatoire.';
        if ($mot_de_passe !== $confirmation_mot_de_passe) $errors['confirmation_mot_de_passe'] = 'Les mots de passe ne correspondent pas.';
        if (count($loisirs) < 2 || count($loisirs) > 4) $errors['loisirs'] = 'Veuillez sélectionner entre 2 et 4 loisirs.';
        if (!$consentement) $errors['consentement'] = 'Le consentement est obligatoire.';
        if (strlen($description) > 978) $errors['description'] = 'La description ne doit pas dépasser 978 caractères.';


        // Avatar Upload Handling (after other validations)
        if (empty($errors) && isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatar = $_FILES['avatar'];
            $allowed_types = ['image/png', 'image/jpeg', 'image/gif'];
            $max_size = 2 * 1024 * 1024; // 2MB

            if (!in_array($avatar['type'], $allowed_types)) {
                $errors['avatar'] = 'Type de fichier non autorisé. Formats acceptés: PNG, JPEG, GIF.';
            } elseif ($avatar['size'] > $max_size) {
                $errors['avatar'] = 'Fichier trop volumineux. Taille maximale: 2MB.';
            } else {
                $upload_dir = 'assets/img/avatars/';
                $file_extension = pathinfo($avatar['name'], PATHINFO_EXTENSION);
                $unique_filename = uniqid('avatar_') . '.' . $file_extension;
                $destination = $upload_dir . $unique_filename;

                if (move_uploaded_file($avatar['tmp_name'], $destination)) {
                    $user_data['avatar'] = $unique_filename; // Store filename in user data
                } else {
                    $errors['avatar'] = 'Erreur lors de l\'upload de l\'avatar.';
                }
            }
        } elseif (empty($errors) && isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE && $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            $errors['avatar'] = 'Erreur lors de l\'upload de l\'avatar.'; // General upload error
        }


        // Check if email already exists
        if (empty($errors)) {
            if (is_user_registered($email)) {
                $errors['email'] = 'Cet email est déjà enregistré.';
                $errors['global'] = 'Une erreur est survenue.'; // Global error message
                $user_data['email'] = ''; // Clear email field
                $user_data['mot_de_passe'] = ''; // Clear password fields
                $user_data['confirmation_mot_de_passe'] = '';
            } else {
                // Save user data
                $data_to_save_array = [
                    $nom, $prenom, $email, $age, $sexe,
                    $adresse_numero, $adresse_rue, $adresse_zip, $adresse_ville,
                    $nationalite, $pays_naissance, $description, implode(',', $loisirs),
                    password_hash($mot_de_passe, PASSWORD_DEFAULT),
                    $consentement ? 'oui' : 'non',
                    $user_data['avatar'] // Add avatar filename to saved data
                ];
                $data_to_save = implode(';', $data_to_save_array) . "\n";

                file_put_contents('utilisateur.txt', $data_to_save, FILE_APPEND | LOCK_EX);
                $success = true;
            }
        }
    }

    if ($success) {
        $_SESSION['user_data'] = $user_data; // Store user data in session for success page
        $user_name = $user_data['prenom'] . ' ' . $user_data['nom'];
        header("Location: views/success.php?name=" . urlencode($user_name));
        exit();
    }

    return ['errors' => $errors, 'success' => $success, 'user_data' => $user_data];
}

function is_user_registered($email) {
    if (!file_exists('utilisateur.txt')) {
        return false;
    }
    $file = fopen('utilisateur.txt', 'r');
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $user_info = explode(';', $line);
            if (isset($user_info[2]) && trim($user_info[2]) === $email) { // Email is the 3rd element (index 2)
                fclose($file);
                return true;
            }
        }
        fclose($file);
    }
    return false;
}
?>