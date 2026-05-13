<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="form-section">
  <h3>Ajouter un type de congé</h3>
  <form method="POST" action="<?= base_url('admin/types-conge/store') ?>">
    <?= csrf_field() ?>
    <div class="form-grid-2">
      <div class="f-group">
        <label class="f-label">Nom du type</label>
        <input type="text" name="nom" class="f-input" placeholder="ex: Congé annuel" />
      </div>
      <div class="f-group">
        <label class="f-label">Jours par an</label>
        <input type="number" name="jours" class="f-input" placeholder="30" />
      </div>
      <div class="f-group">
        <label class="f-label">Couleur</label>
        <input type="color" name="couleur" class="f-input" value="#2d5a3d" />
      </div>
      <div class="f-group">
        <label class="f-label">Actif</label>
        <select name="actif" class="f-select">
          <option value="1">Oui</option>
          <option value="0">Non</option>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Ajouter</button>
    </div>
  </form>
</div>

<div class="data-card">
  <div class="data-card-head"><h3>Types de congé configurés</h3></div>
  <table class="tbl">
    <thead>
      <tr><th>Type</th><th>Jours/an</th><th>Couleur</th><th>Statut</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <tr>
        <td><span class="type-badge t-annuel">Congé annuel</span></td>
        <td class="td-mono">30 j</td>
        <td><div style="width:20px;height:20px;background:#2d5a3d;border-radius:4px"></div></td>
        <td><span class="statut s-approuvee" style="font-size:.68rem">Actif</span></td>
        <td><a href="#" class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</a></td>
      </tr>
      <tr>
        <td><span class="type-badge t-maladie">Maladie</span></td>
        <td class="td-mono">10 j</td>
        <td><div style="width:20px;height:20px;background:#1a4f7a;border-radius:4px"></div></td>
        <td><span class="statut s-approuvee" style="font-size:.68rem">Actif</span></td>
        <td><a href="#" class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</a></td>
      </tr>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
