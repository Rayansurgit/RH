<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Métriques de l'employé -->
<div class="metrics">
  <?php foreach ($soldes as $solde): ?>
  <div class="metric">
    <div class="metric-top"><div class="metric-icon mi-forest"><i class="bi bi-calendar-check"></i></div></div>
    <div class="metric-val"><?= $solde['restant'] ?? 0 ?></div>
    <div class="metric-label"><?= htmlspecialchars($solde['type_name'] ?? 'Type') ?> restants</div>
  </div>
  <?php endforeach; ?>
  <div class="metric">
    <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-inbox"></i></div></div>
    <div class="metric-val"><?= $pendingCount ?></div>
    <div class="metric-label">Demandes en attente</div>
  </div>
</div>

<!-- Soldes de congés -->
<div class="data-card">
  <div class="data-card-head"><h3>Mes soldes de congés — <?= $annee ?></h3></div>
  <div style="padding:1rem 1.25rem;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem">
    <?php foreach ($soldes as $solde): ?>
    <div class="solde-card" style="margin:0">
      <div class="solde-header">
        <span class="solde-type"><?= htmlspecialchars($solde['type_name'] ?? 'Type') ?></span>
        <span class="solde-nums"><strong><?= $solde['restant'] ?? 0 ?></strong> / <?= $solde['jours_attribues'] ?? 0 ?> j</span>
      </div>
      <div class="solde-bar">
        <div class="solde-fill <?= ($solde['restant'] ?? 0) <= 2 ? 'warn' : '' ?>" 
             style="width:<?= ($solde['jours_attribues'] > 0) ? (($solde['restant'] ?? 0 / $solde['jours_attribues']) * 100) : 0 ?>%"></div>
      </div>
      <div class="solde-label"><?= $solde['restant'] ?? 0 ?> jours restants · <?= $solde['jours_pris'] ?? 0 ?> pris</div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Dernières demandes -->
<div class="data-card">
  <div class="data-card-head">
    <h3>Mes dernières demandes</h3>
    <a href="<?= base_url('employe/conges') ?>" style="font-size:.8rem;color:var(--forest);text-decoration:none">Voir tout →</a>
  </div>
  <table class="tbl">
    <thead>
      <tr><th>Type</th><th>Du</th><th>Au</th><th>Durée</th><th>Statut</th><th>Action</th></tr>
    </thead>
    <tbody>
      <?php if (empty($recentRequests)): ?>
      <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--muted)">Aucune demande de congé.</td></tr>
      <?php else: ?>
        <?php foreach ($recentRequests as $req): ?>
      <tr>
        <td><span class="type-badge <?= strpos($req['type_name'], 'annuel') !== false ? 't-annuel' : (strpos($req['type_name'], 'maladie') !== false ? 't-maladie' : (strpos($req['type_name'], 'spécial') !== false ? 't-special' : '')) ?>"><?= htmlspecialchars($req['type_name']) ?></span></td>
        <td class="td-muted"><?= date('d/m/Y', strtotime($req['date_debut'])) ?></td>
        <td class="td-muted"><?= date('d/m/Y', strtotime($req['date_fin'])) ?></td>
        <td class="td-mono"><?= $req['nb_jours'] ?> j</td>
        <td><span class="statut s-<?= $req['status'] === 'en_attente' ? 'attente' : ($req['status'] === 'approuvee' ? 'approuvee' : ($req['status'] === 'refusee' ? 'refusee' : 'annulee')) ?>"><?= htmlspecialchars($req['status']) ?></span></td>
        <td>
          <?php if ($req['status'] === 'en_attente'): ?>
          <a href="<?= base_url('employe/conges/cancel/' . $req['id']) ?>" class="btn-sm btn-cancel"><i class="bi bi-x"></i> Annuler</a>
          <?php else: ?>
          <span class="td-muted" style="font-size:.75rem">—</span>
          <?php endif; ?>
        </td>
      </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
