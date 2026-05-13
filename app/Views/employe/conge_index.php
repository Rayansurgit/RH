<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="data-card">
  <div class="data-card-head">
    <h3>Toutes mes demandes</h3>
    <div style="display:flex;gap:6px">
      <select class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto" onchange="filterByStatus(this.value)">
        <option value="">Tous les statuts</option>
        <option value="en_attente">En attente</option>
        <option value="approuvee">Approuvée</option>
        <option value="refusee">Refusée</option>
        <option value="annulee">Annulée</option>
      </select>
    </div>
  </div>
  <table class="tbl">
    <thead>
      <tr><th>Type</th><th>Début</th><th>Fin</th><th>Durée</th><th>Statut</th><th>Commentaire RH</th><th>Action</th></tr>
    </thead>
    <tbody>
      <?php if (empty($requests)): ?>
      <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--muted)">Aucune demande de congé.</td></tr>
      <?php else: ?>
        <?php foreach ($requests as $request): ?>
      <tr>
        <td><span class="type-badge<?= $request['type_name'] === 'Congé annuel' ? ' t-annuel' : ($request['type_name'] === 'Congé maladie' ? ' t-maladie' : ($request['type_name'] === 'Congé spécial' ? ' t-special' : '')) ?>"><?= htmlspecialchars($request['type_name']) ?></span></td>
        <td class="td-muted"><?= date('d/m/Y', strtotime($request['date_debut'])) ?></td>
        <td class="td-muted"><?= date('d/m/Y', strtotime($request['date_fin'])) ?></td>
        <td class="td-mono"><?= $request['nb_jours'] ?> j</td>
        <td><span class="statut s-<?= $request['status'] === 'en_attente' ? 'attente' : ($request['status'] === 'approuvee' ? 'approuvee' : ($request['status'] === 'refusee' ? 'refusee' : 'annulee')) ?>"><?= htmlspecialchars($request['status']) ?></span></td>
        <td style="font-size:.78rem;<?= $request['status'] === 'approuvee' ? 'color:var(--success)' : ($request['status'] === 'refusee' ? 'color:var(--danger)' : 'color:var(--muted)') ?>">
          <?php if ($request['status'] === 'approuvee'): ?>
          <i class="bi bi-check-circle"></i> Validé
          <?php elseif ($request['status'] === 'refusee'): ?>
          <?= htmlspecialchars($request['commentaire'] ?? 'Refusée') ?>
          <?php else: ?>
          —
          <?php endif; ?>
        </td>
        <td>
          <?php if ($request['status'] === 'en_attente'): ?>
          <a href="<?= base_url('employe/conges/cancel/' . $request['id']) ?>" class="btn-sm btn-cancel" onclick="return confirm('Annuler cette demande?')"><i class="bi bi-x"></i> Annuler</a>
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

<script>
function filterByStatus(status) {
  if (status) {
    window.location.href = '<?= base_url('employe/conges') ?>?status=' + status;
  } else {
    window.location.href = '<?= base_url('employe/conges') ?>';
  }
}
</script>

<?= $this->endSection() ?>

