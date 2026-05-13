<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<form method="POST" action="<?= base_url('auth/login') ?>">
  <?= csrf_field() ?>

  <div class="f-group">
    <label class="f-label">Adresse email</label>
    <input type="email" name="email" class="f-input" placeholder="vous@techmada.mg" value="<?= old('email') ?>" required/>
    <?php if ($errors = session('errors')) { ?>
      <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= $errors['email'] ?? '' ?></div>
    <?php } ?>
  </div>

  <div class="f-group">
    <label class="f-label">Mot de passe</label>
    <input type="password" name="password" class="f-input" placeholder="Votre mot de passe" required/>
    <?php if ($errors = session('errors')) { ?>
      <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= $errors['password'] ?? '' ?></div>
    <?php } ?>
  </div>

  <button type="submit" class="btn-primary"><i class="bi bi-box-arrow-in-right"></i> Se connecter</button>

  <div class="auth-footer">
    Pas encore de compte? <a href="<?= base_url('auth/register') ?>">S'inscrire ici</a>
  </div>
</form>

<?= $this->endSection() ?>
