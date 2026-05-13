<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="form-section">
  <h3>Modifier l'employé</h3>
  <form method="POST" action="<?= base_url('admin/employes/update/' . ($id ?? '')) ?>">
    <?= csrf_field() ?>
    
    <div class="form-grid-2" style="margin-bottom:1rem">
      <div class="f-group">
        <label class="f-label">Prénom</label>
        <input type="text" name="prenom" class="f-input" placeholder="Jean" value="<?= old('prenom', 'Soa') ?>"/>
      </div>
      <div class="f-group">
        <label class="f-label">Nom</label>
        <input type="text" name="nom" class="f-input" placeholder="Rakoto" value="<?= old('nom', 'Rakoto') ?>"/>
      </div>
      <div class="f-group">
        <label class="f-label">Email</label>
        <input type="email" name="email" class="f-input" placeholder="jean.rakoto@techmada.mg" value="<?= old('email', 'soa@techmada.mg') ?>"/>
      </div>
      <div class="f-group">
        <label class="f-label">Département</label>
        <select name="departement" class="f-select">
          <option value="">-- Choisir --</option>
          <option value="IT" <?= old('departement', 'IT') === 'IT' ? 'selected' : '' ?>>IT</option>
          <option value="Finance" <?= old('departement') === 'Finance' ? 'selected' : '' ?>>Finance</option>
          <option value="Marketing" <?= old('departement') === 'Marketing' ? 'selected' : '' ?>>Marketing</option>
          <option value="RH" <?= old('departement') === 'RH' ? 'selected' : '' ?>>RH</option>
        </select>
      </div>
      <div class="f-group">
        <label class="f-label">Rôle</label>
        <select name="role" class="f-select">
          <option value="employe" <?= old('role', 'employe') === 'employe' ? 'selected' : '' ?>>Employé</option>
          <option value="rh" <?= old('role') === 'rh' ? 'selected' : '' ?>>Responsable RH</option>
          <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Administrateur</option>
        </select>
      </div>
      <div class="f-group">
        <label class="f-label">Date d'embauche</label>
        <input type="date" name="date_embauche" class="f-input" value="<?= old('date_embauche', '2022-03-01') ?>"/>
      </div>
    </div>

    <div style="background:var(--warn-bg);border:1px solid var(--warn-br);border-radius:8px;padding:1rem;margin-bottom:1.5rem">
      <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
        <input type="checkbox" name="reset_password" value="1" />
        <span style="font-size:.875rem;color:var(--warn)"><i class="bi bi-exclamation-triangle"></i> Réinitialiser le mot de passe</span>
      </label>
      <div style="font-size:.75rem;color:var(--muted);margin-top:6px">L'employé recevra un lien pour définir un nouveau mot de passe.</div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-forest"><i class="bi bi-check"></i> Enregistrer les modifications</button>
      <a href="<?= base_url('admin/employes') ?>" class="btn-secondary"><i class="bi bi-x"></i> Annuler</a>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
