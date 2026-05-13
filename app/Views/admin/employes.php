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
        <select name="departement" class="f-select">
          <option value="">-- Choisir --</option>
          <option value="IT">IT</option>
          <option value="Finance">Finance</option>
          <option value="Marketing">Marketing</option>
          <option value="RH">RH</option>
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
      <tr>
        <td>
          <div class="profile-row">
            <div class="avatar av-green" style="width:32px;height:32px;font-size:.68rem">SR</div>
            <div class="profile-info"><div class="pname">Soa Rakoto</div><div class="pdept">soa@techmada.mg</div></div>
          </div>
        </td>
        <td class="td-muted">IT</td>
        <td><span class="type-badge" style="background:#f1efe8;color:#444441">employe</span></td>
        <td class="td-muted td-mono" style="font-size:.78rem">2022-03-01</td>
        <td><span class="statut s-approuvee" style="font-size:.68rem">actif</span></td>
        <td><span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--forest)">18 / 30 j</span></td>
        <td>
          <div class="action-btns">
            <a href="<?= base_url('admin/employes/edit/1') ?>" class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</a>
            <a href="#" class="btn-sm btn-del" onclick="return confirm('Supprimer?')"><i class="bi bi-slash-circle"></i></a>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="profile-row">
            <div class="avatar av-blue" style="width:32px;height:32px;font-size:.68rem">MR</div>
            <div class="profile-info"><div class="pname">Marie Rabe</div><div class="pdept">rh@techmada.mg</div></div>
          </div>
        </td>
        <td class="td-muted">RH</td>
        <td><span class="type-badge t-maladie">rh</span></td>
        <td class="td-muted td-mono" style="font-size:.78rem">2020-01-15</td>
        <td><span class="statut s-approuvee" style="font-size:.68rem">actif</span></td>
        <td><span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--forest)">25 / 30 j</span></td>
        <td>
          <div class="action-btns">
            <a href="<?= base_url('admin/employes/edit/2') ?>" class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</a>
            <a href="#" class="btn-sm btn-del" onclick="return confirm('Supprimer?')"><i class="bi bi-slash-circle"></i></a>
          </div>
        </td>
      </tr>
      <tr style="opacity:.5">
        <td>
          <div class="profile-row">
            <div class="avatar av-amber" style="width:32px;height:32px;font-size:.68rem">TF</div>
            <div class="profile-info"><div class="pname">Tsiry Fidy</div><div class="pdept">tsiry@techmada.mg</div></div>
          </div>
        </td>
        <td class="td-muted">Finance</td>
        <td><span class="type-badge" style="background:#f1efe8;color:#444441">employe</span></td>
        <td class="td-muted td-mono" style="font-size:.78rem">2019-07-10</td>
        <td><span class="statut s-annulee" style="font-size:.68rem">inactif</span></td>
        <td><span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--muted)">— / — j</span></td>
        <td>
          <div class="action-btns">
            <a href="#" class="btn-sm btn-view"><i class="bi bi-arrow-counterclockwise"></i> Réactiver</a>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
