<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="data-card">
  <div class="data-card-head">
    <h3>Toutes mes demandes</h3>
    <div style="display:flex;gap:6px">
      <select class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto">
        <option>Tous les statuts</option>
        <option>En attente</option>
        <option>Approuvée</option>
        <option>Refusée</option>
        <option>Annulée</option>
      </select>
    </div>
  </div>
  <table class="tbl">
    <thead>
      <tr><th>Type</th><th>Début</th><th>Fin</th><th>Durée</th><th>Statut</th><th>Commentaire RH</th><th>Action</th></tr>
    </thead>
    <tbody>
      <tr>
        <td><span class="type-badge t-annuel">Annuel</span></td>
        <td class="td-muted">23 juin 2025</td>
        <td class="td-muted">27 juin 2025</td>
        <td class="td-mono">5 j</td>
        <td><span class="statut s-attente">en attente</span></td>
        <td class="td-muted" style="font-size:.78rem">—</td>
        <td><a href="#" class="btn-sm btn-cancel" onclick="return confirm('Annuler cette demande?')"><i class="bi bi-x"></i> Annuler</a></td>
      </tr>
      <tr>
        <td><span class="type-badge t-maladie">Maladie</span></td>
        <td class="td-muted">2 juin 2025</td>
        <td class="td-muted">3 juin 2025</td>
        <td class="td-mono">2 j</td>
        <td><span class="statut s-approuvee">approuvée</span></td>
        <td style="font-size:.78rem;color:var(--success)"><i class="bi bi-check-circle"></i> Validé</td>
        <td><span class="td-muted" style="font-size:.75rem">—</span></td>
      </tr>
      <tr>
        <td><span class="type-badge t-annuel">Annuel</span></td>
        <td class="td-muted">12 mai 2025</td>
        <td class="td-muted">16 mai 2025</td>
        <td class="td-mono">5 j</td>
        <td><span class="statut s-approuvee">approuvée</span></td>
        <td style="font-size:.78rem;color:var(--success)"><i class="bi bi-check-circle"></i> OK</td>
        <td><span class="td-muted" style="font-size:.75rem">—</span></td>
      </tr>
      <tr>
        <td><span class="type-badge t-special">Spécial</span></td>
        <td class="td-muted">5 avr. 2025</td>
        <td class="td-muted">5 avr. 2025</td>
        <td class="td-mono">1 j</td>
        <td><span class="statut s-refusee">refusée</span></td>
        <td style="font-size:.78rem;color:var(--danger)">Chevauchement détecté</td>
        <td><span class="td-muted" style="font-size:.75rem">—</span></td>
      </tr>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
