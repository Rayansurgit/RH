<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session('success')) { ?>
  <div class="flash flash-success">
    <i class="bi bi-check-circle-fill"></i>
    <?= session('success') ?>
  </div>
<?php } ?>
<?php if (session('error')) { ?>
  <div class="flash flash-error">
    <i class="bi bi-exclamation-circle-fill"></i>
    <?= session('error') ?>
  </div>
<?php } ?>

<!-- Filtre -->
<div style="display:flex;gap:8px;margin-bottom:1.25rem;flex-wrap:wrap">
  <a href="<?= base_url('rh/conges') ?>" class="btn-filter <?= $currentStatus === 'all' ? 'active' : '' ?>">Tous (<?= $stats['all'] ?>)</a>
  <a href="<?= base_url('rh/conges?status=en_attente') ?>" class="btn-filter <?= $currentStatus === 'en_attente' ? 'active' : '' ?>">En attente (<?= $stats['pending'] ?>)</a>
  <a href="<?= base_url('rh/conges?status=approuvee') ?>" class="btn-filter <?= $currentStatus === 'approuvee' ? 'active' : '' ?>">Approuvées (<?= $stats['approved'] ?>)</a>
  <a href="<?= base_url('rh/conges?status=refusee') ?>" class="btn-filter <?= $currentStatus === 'refusee' ? 'active' : '' ?>">Refusées (<?= $stats['refused'] ?>)</a>
</div>

<style>
.btn-filter {
  padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);background:var(--white);color:var(--muted);cursor:pointer;text-decoration:none;display:inline-block;
}
.btn-filter.active {
  border-color:var(--forest);background:var(--forest);color:var(--white);
}
</style>

<div class="data-card">
  <div class="data-card-head"><h3>Toutes les demandes</h3></div>
  <table class="tbl">
    <thead>
      <tr><th>Employé</th><th>Type</th><th>Période</th><th>Durée</th><th>Solde dispo</th><th>Statut</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php if (empty($requests)): ?>
      <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--muted)">Aucune demande.</td></tr>
      <?php else: ?>
        <?php foreach ($requests as $req): ?>
      <tr>
        <td>
          <div class="profile-row">
            <div class="avatar av-green" style="width:32px;height:32px;font-size:.7rem"><?= strtoupper(substr($req['employee_prenom'] ?? '', 0, 1) . substr($req['employee_name'] ?? '', 0, 1)) ?></div>
            <div class="profile-info">
              <div class="pname"><?= htmlspecialchars($req['employee_prenom'] ?? '' . ' ' . $req['employee_name'] ?? '') ?></div>
              <div class="pdept"><?= date('d/m', strtotime($req['date_debut'])) ?> → <?= date('d/m', strtotime($req['date_fin'])) ?></div>
            </div>
          </div>
        </td>
        <td><span class="type-badge<?= strpos($req['type_libelle'], 'annuel') !== false ? ' t-annuel' : (strpos($req['type_libelle'], 'maladie') !== false ? ' t-maladie' : (strpos($req['type_libelle'], 'spécial') !== false ? ' t-special' : '')) ?>"><?= htmlspecialchars($req['type_libelle'] ?? 'Type') ?></span></td>
        <td class="td-muted" style="font-size:.8rem"><?= date('d/m/Y', strtotime($req['date_debut'])) ?> – <?= date('d/m/Y', strtotime($req['date_fin'])) ?></td>
        <td class="td-mono"><?= $req['nb_jours'] ?> j</td>
        <td>
          <span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--success);font-weight:500"><?= $req['solde_restant'] ?? 0 ?> j</span>
          <span style="font-size:.72rem;color:var(--muted)"> dispo</span>
        </td>
        <td><span class="statut s-<?= $req['status'] === 'en_attente' ? 'attente' : ($req['status'] === 'approuvee' ? 'approuvee' : ($req['status'] === 'refusee' ? 'refusee' : 'annulee')) ?>"><?= htmlspecialchars($req['status']) ?></span></td>
        <td>
          <?php if ($req['status'] === 'en_attente'): ?>
          <div class="action-btns">
            <form method="POST" action="<?= base_url('rh/conges/approve/' . $req['id']) ?>" style="display:inline;">
              <?= csrf_field() ?>
              <button type="submit" class="btn-sm btn-approve"><i class="bi bi-check-lg"></i> Approuver</button>
            </form>
            <form method="POST" action="<?= base_url('rh/conges/refuse/' . $req['id']) ?>" style="display:inline;">
              <?= csrf_field() ?>
              <input type="hidden" name="commentaire" value="Refusée par le RH"/>
              <button type="submit" class="btn-sm btn-refuse"><i class="bi bi-x-lg"></i> Refuser</button>
            </form>
          </div>
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
      <tr>
        <td>
          <div class="profile-row">
            <div class="avatar av-amber" style="width:32px;height:32px;font-size:.7rem">TF</div>
            <div class="profile-info">
              <div class="pname">Tsiry Fidy</div>
              <div class="pdept">Finance</div>
            </div>
          </div>
        </td>
        <td><span class="type-badge t-maladie">Maladie</span></td>
        <td class="td-muted" style="font-size:.8rem">18/06 – 19/06/2025</td>
        <td class="td-mono">2 j</td>
        <td>
          <span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--warn);font-weight:500">1 j</span>
          <span style="font-size:.72rem;color:var(--danger)"> ⚠ insuffisant</span>
        </td>
        <td><span class="statut s-attente">en attente</span></td>
        <td>
          <div class="action-btns">
            <button class="btn-sm btn-approve" disabled style="opacity:.4;cursor:not-allowed"><i class="bi bi-check-lg"></i> Approuver</button>
            <a href="<?= base_url('rh/conges/refuse') ?>" class="btn-sm btn-refuse"><i class="bi bi-x-lg"></i> Refuser</a>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="profile-row">
            <div class="avatar av-blue" style="width:32px;height:32px;font-size:.7rem">HA</div>
            <div class="profile-info">
              <div class="pname">Haja Andria</div>
              <div class="pdept">Marketing</div>
            </div>
          </div>
        </td>
        <td><span class="type-badge t-annuel">Annuel</span></td>
        <td class="td-muted" style="font-size:.8rem">30/06 – 04/07/2025</td>
        <td class="td-mono">5 j</td>
        <td>
          <span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--success);font-weight:500">22 j</span>
          <span style="font-size:.72rem;color:var(--muted)"> dispo</span>
        </td>
        <td><span class="statut s-attente">en attente</span></td>
        <td>
          <div class="action-btns">
            <a href="<?= base_url('rh/conges/approve') ?>" class="btn-sm btn-approve"><i class="bi bi-check-lg"></i> Approuver</a>
            <a href="<?= base_url('rh/conges/refuse') ?>" class="btn-sm btn-refuse"><i class="bi bi-x-lg"></i> Refuser</a>
          </div>
        </td>
      </tr>
      <!-- Déjà traitées -->
      <tr>
        <td>
          <div class="profile-row">
            <div class="avatar av-green" style="width:32px;height:32px;font-size:.7rem">SR</div>
            <div class="profile-info"><div class="pname">Soa Rakoto</div><div class="pdept">IT</div></div>
          </div>
        </td>
        <td><span class="type-badge t-maladie">Maladie</span></td>
        <td class="td-muted" style="font-size:.8rem">02/06 – 03/06/2025</td>
        <td class="td-mono">2 j</td>
        <td><span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--muted)">—</span></td>
        <td><span class="statut s-approuvee">approuvée</span></td>
        <td><span class="td-muted" style="font-size:.75rem">Traité par Marie R.</span></td>
      </tr>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
