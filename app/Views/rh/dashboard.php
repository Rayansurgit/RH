<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Métriques RH -->
<div class="metrics">
  <div class="metric">
    <div class="metric-top"><div class="metric-icon mi-forest"><i class="bi bi-hourglass-split"></i></div></div>
    <div class="metric-val">4</div>
    <div class="metric-label">En attente</div>
  </div>
  <div class="metric">
    <div class="metric-top"><div class="metric-icon mi-green"><i class="bi bi-calendar-check"></i></div></div>
    <div class="metric-val">31</div>
    <div class="metric-label">Approuvées ce mois</div>
  </div>
  <div class="metric">
    <div class="metric-top"><div class="metric-icon mi-red"><i class="bi bi-calendar-x"></i></div></div>
    <div class="metric-val">2</div>
    <div class="metric-label">Refusées ce mois</div>
  </div>
  <div class="metric">
    <div class="metric-top"><div class="metric-icon mi-blue"><i class="bi bi-people"></i></div></div>
    <div class="metric-val">24</div>
    <div class="metric-label">Employés actifs</div>
  </div>
</div>

<!-- Demandes en attente -->
<div class="data-card">
  <div class="data-card-head">
    <h3><i class="bi bi-hourglass-split" style="color:var(--warn);margin-right:8px"></i>Demandes en attente (4)</h3>
    <a href="<?= base_url('rh/conges') ?>" style="font-size:.8rem;color:var(--forest);text-decoration:none">Traiter →</a>
  </div>
  <table class="tbl">
    <thead>
      <tr><th>Employé</th><th>Type</th><th>Dates</th><th>Durée</th><th>Priorité</th></tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <div class="profile-row">
            <div class="avatar av-green" style="width:28px;height:28px;font-size:.62rem">SR</div>
            <span style="font-size:.84rem">Soa Rakoto</span>
          </div>
        </td>
        <td><span class="type-badge t-annuel">Annuel</span></td>
        <td class="td-muted" style="font-size:.78rem">23 – 27 juin</td>
        <td class="td-mono">5 j</td>
        <td><span class="statut s-attente">Attente</span></td>
      </tr>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
