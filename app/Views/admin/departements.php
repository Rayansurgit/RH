<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="form-section">
  <h3>Ajouter un département</h3>
  <form method="POST" action="<?= base_url('admin/departements/store') ?>">
    <?= csrf_field() ?>
    <div class="f-group" style="max-width:600px">
      <label class="f-label">Nom du département</label>
      <input type="text" name="nom" class="f-input" placeholder="ex: IT, Finance, Marketing" />
    </div>
    <div class="form-actions">
      <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Ajouter</button>
    </div>
  </form>
</div>

<div class="data-card">
  <div class="data-card-head"><h3>Tous les départements</h3></div>
  <table class="tbl">
    <thead>
      <tr><th>Département</th><th>Employés</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <tr>
        <td>IT</td>
        <td class="td-muted">8 employés</td>
        <td><a href="#" class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</a></td>
      </tr>
      <tr>
        <td>Finance</td>
        <td class="td-muted">5 employés</td>
        <td><a href="#" class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</a></td>
      </tr>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
