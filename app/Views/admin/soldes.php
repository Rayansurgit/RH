<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="form-section">
  <h3>Configurer les soldes annuels</h3>
  <form method="POST" action="<?= base_url('admin/soldes/update') ?>">
    <?= csrf_field() ?>
    <div class="form-grid-2">
      <div class="f-group">
        <label class="f-label">Année</label>
        <input type="number" name="annee" class="f-input" value="2025" />
      </div>
      <div class="f-group">
        <label class="f-label">Congé annuel</label>
        <input type="number" name="conge_annuel" class="f-input" value="30" />
      </div>
      <div class="f-group">
        <label class="f-label">Congé maladie</label>
        <input type="number" name="conge_maladie" class="f-input" value="10" />
      </div>
      <div class="f-group">
        <label class="f-label">Congé spécial</label>
        <input type="number" name="conge_special" class="f-input" value="5" />
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn-forest"><i class="bi bi-check"></i> Configurer</button>
      <a href="<?= base_url('admin/dashboard') ?>" class="btn-secondary">Annuler</a>
    </div>
  </form>
</div>

<div class="data-card">
  <div class="data-card-head"><h3>Configuration actuelle - 2025</h3></div>
  <div style="padding:1.5rem">
    <div class="metrics" style="margin:0">
      <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-forest"><i class="bi bi-calendar"></i></div></div>
        <div class="metric-val">30</div>
        <div class="metric-label">Jours annuel</div>
      </div>
      <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-blue"><i class="bi bi-calendar"></i></div></div>
        <div class="metric-val">10</div>
        <div class="metric-label">Jours maladie</div>
      </div>
      <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-calendar"></i></div></div>
        <div class="metric-val">5</div>
        <div class="metric-label">Jours spécial</div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
