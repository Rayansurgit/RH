<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Formulaire ajout -->
<div class="form-section">
  <h3><i class="bi bi-person-plus" style="color:var(--forest);margin-right:6px"></i>Ajouter un employé</h3>
  <form method="POST" action="<?= base_url('admin/employes/store') ?>">
    <?= csrf_field() ?>
    
    <div class="form-grid-2" style="margin-bottom:1rem">
      <div class="f-group">
        <label class="f-label">Prénom</label>
        <input type="text" name="prenom" class="f-input" placeholder="Jean" value="<?= old('prenom') ?>"/>
      </div>
      <div class="f-group">
        <label class="f-label">Nom</label>
        <input type="text" name="nom" class="f-input" placeholder="Rakoto" value="<?= old('nom') ?>"/>
      </div>
      <div class="f-group">
        <label class="f-label">Email</label>
        <input type="email" name="email" class="f-input" placeholder="jean.rakoto@techmada.mg" value="<?= old('email') ?>"/>
      </div>
      <div class="f-group">
        <label class="f-label">Mot de passe initial</label>
        <input type="password" name="password" class="f-input" placeholder="À communiquer à l'employé"/>
      </div>
      <div class="f-group">
        <label class="f-label">Département</label>
        <select name="id_department" class="f-select" required>
          <option value="">-- Choisir --</option>
          <?php foreach ($departments as $dept): ?>
          <option value="<?= $dept['id'] ?>" <?= old('id_department') == $dept['id'] ? 'selected' : '' ?>><?= htmlspecialchars($dept['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="f-group">
        <label class="f-label">Rôle</label>
        <select name="role" class="f-select">
          <option value="employe">Employé</option>
          <option value="rh">Responsable RH</option>
          <option value="admin">Administrateur</option>
        </select>
      </div>
      <div class="f-group">
        <label class="f-label">Date d'embauche</label>
        <input type="date" name="date_embauche" class="f-input" value="<?= old('date_embauche', date('Y-m-d')) ?>"/>
      </div>
    </div>
    <div class="flash flash-info" style="margin-bottom:1rem">
      <i class="bi bi-info-circle-fill"></i>
      <span style="font-size:.82rem">Les soldes de congés seront initialisés automatiquement selon les types de congé configurés.</span>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Créer l'employé</button>
      <a href="<?= base_url('admin/employes') ?>" class="btn-secondary">Réinitialiser</a>
    </div>
  </form>
</div>

<!-- Liste employés -->
<div class="data-card">
  <div class="data-card-head">
    <h3>Tous les employés</h3>
    <div style="display:flex;gap:6px">
      <input type="text" class="f-input" placeholder="Rechercher..." style="width:200px;padding:6px 10px;font-size:.8rem"/>
      <select class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto">
        <option>Tous les depts</option>
        <option>IT</option>
        <option>Finance</option>
        <option>Marketing</option>
      </select>
    </div>
  </div>
  <table class="tbl">
    <thead>
      <tr><th>Employé</th><th>Département</th><th>Rôle</th><th>Embauche</th><th>Statut</th><th>Solde annuel</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php if (empty($employees)): ?>
      <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--muted)">Aucun employé.</td></tr>
      <?php else: ?>
        <?php foreach ($employees as $emp): ?>
      <tr <?= !$emp['actif'] ? 'style="opacity:.5"' : '' ?>>
        <td>
          <div class="profile-row">
            <div class="avatar av-green" style="width:32px;height:32px;font-size:.68rem"><?= strtoupper(substr($emp['prenom'], 0, 1) . substr($emp['name'], 0, 1)) ?></div>
            <div class="profile-info">
              <div class="pname"><?= htmlspecialchars($emp['prenom'] . ' ' . $emp['name']) ?></div>
              <div class="pdept"><?= htmlspecialchars($emp['email']) ?></div>
            </div>
          </div>
        </td>
        <td class="td-muted">
          <?php 
            $dept = array_filter($departments, fn($d) => $d['id'] == $emp['id_department']);
            echo htmlspecialchars(reset($dept)['name'] ?? 'N/A');
          ?>
        </td>
        <td><span class="type-badge"><?= htmlspecialchars($emp['role']) ?></span></td>
        <td class="td-muted td-mono" style="font-size:.78rem"><?= $emp['date_embauche'] ?></td>
        <td><span class="statut s-<?= $emp['actif'] ? 'approuvee' : 'annulee' ?>" style="font-size:.68rem"><?= $emp['actif'] ? 'actif' : 'inactif' ?></span></td>
        <td><span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--forest)">— / 30 j</span></td>
        <td>
          <div class="action-btns">
            <a href="<?= base_url('admin/employes/edit/' . $emp['id']) ?>" class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</a>
            <a href="<?= base_url('admin/employes/delete/' . $emp['id']) ?>" class="btn-sm btn-del" onclick="return confirm('Supprimer?')"><i class="bi bi-slash-circle"></i></a>
          </div>
        </td>
      </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
