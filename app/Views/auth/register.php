<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<form method="POST" action="<?= base_url('auth/register') ?>">
  <?= csrf_field() ?>

  <div class="f-group">
    <label class="f-label">Prénom</label>
    <input type="text" name="prenom" class="f-input" placeholder="Jean" value="<?= old('prenom') ?>" required/>
    <?php if ($errors = session('errors')) { ?>
      <div class="f-error"><?= $errors['prenom'] ?? '' ?></div>
    <?php } ?>
  </div>

  <div class="f-group">
    <label class="f-label">Nom</label>
    <input type="text" name="nom" class="f-input" placeholder="Rakoto" value="<?= old('nom') ?>" required/>
    <?php if ($errors = session('errors')) { ?>
      <div class="f-error"><?= $errors['nom'] ?? '' ?></div>
    <?php } ?>
  </div>

  <div class="f-group">
    <label class="f-label">Adresse email</label>
    <input type="email" name="email" class="f-input" placeholder="vous@techmada.mg" value="<?= old('email') ?>" required/>
    <?php if ($errors = session('errors')) { ?>
      <div class="f-error"><?= $errors['email'] ?? '' ?></div>
    <?php } ?>
  </div>

  <div class="f-group">
    <label class="f-label">Mot de passe</label>
    <input type="password" name="password" class="f-input" placeholder="Au moins 8 caractères" required/>
    <?php if ($errors = session('errors')) { ?>
      <div class="f-error"><?= $errors['password'] ?? '' ?></div>
    <?php } ?>
  </div>

  <button type="submit" class="btn-primary"><i class="bi bi-person-plus"></i> Créer le compte</button>

  <div class="auth-footer">
    Vous avez déjà un compte? <a href="<?= base_url('auth/login') ?>">Se connecter</a>
  </div>
</form>

<?= $this->endSection() ?>
