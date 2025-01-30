<?php
session_start(); // Start session to access user data
include '../includes/header.php';

$user_data = $_SESSION['user_data'] ?? []; // Retrieve user data from session
$name = htmlspecialchars($_GET['name'] ?? 'Utilisateur');
$avatar_filename = $user_data['avatar'] ?? ''; // Get avatar filename

?>

<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
  <strong class="font-bold">Succès!</strong>
  <span class="block sm:inline">Bienvenue sur le site <?php echo $name; ?>!</span>
</div>

<?php if ($avatar_filename): ?>
    <div class="mt-4 flex justify-center">
        <img src="../assets/img/avatars/<?php echo htmlspecialchars($avatar_filename); ?>" alt="Avatar de <?php echo $name; ?>" class="rounded-full h-32 w-32 object-cover border-2 border-gray-300">
    </div>
<?php endif; ?>

<div class="mt-4 text-center">
    <p>Vos informations ont été enregistrées avec succès.</p>
    <?php if (!empty($user_data['description'])): ?>
        <p class="mt-2"><strong>Description:</strong> <?php echo htmlspecialchars($user_data['description']); ?></p>
    <?php endif; ?>
    <?php if (!empty($user_data['loisirs'])): ?>
        <p class="mt-2"><strong>Loisirs:</strong> <?php echo htmlspecialchars(implode(', ', $user_data['loisirs'])); ?></p>
    <?php endif; ?>
    <p class="mt-2">Vous pouvez maintenant profiter pleinement de la Communauté de l'Algo !</p>
</div>


<?php include '../includes/footer.php'; ?>