<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session('success')) { ?>
  <div class="flash flash-success">
    <i class="bi bi-check-circle-fill"></i>
    <?= session('success') ?>
  </div>
<?php } ?>

<!-- Filtre -->
<div style="display:flex;gap:8px;margin-bottom:1.25rem;flex-wrap:wrap">
  <button style="padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--forest);background:var(--forest);color:var(--white);cursor:pointer">Tous (8)</button>
  <button style="padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);background:var(--white);color:var(--muted);cursor:pointer">En attente (4)</button>
  <button style="padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);background:var(--white);color:var(--muted);cursor:pointer">Approuvées (3)</button>
  <button style="padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);background:var(--white);color:var(--muted);cursor:pointer">Refusées (1)</button>
  <select class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto;margin-left:auto">
    <option>Tous les départements</option>
    <option>IT</option>
    <option>Finance</option>
    <option>Marketing</option>
  </select>
</div>

<div class="data-card">
  <div class="data-card-head"><h3>Toutes les demandes</h3></div>
  <table class="tbl">
    <thead>
      <tr><th>Employé</th><th>Type</th><th>Période</th><th>Durée</th><th>Solde dispo</th><th>Statut</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <!-- En attente — actions disponibles -->
      <tr>
        <td>
          <div class="profile-row">
            <div class="avatar av-green" style="width:32px;height:32px;font-size:.7rem">SR</div>
            <div class="profile-info">
              <div class="pname">Soa Rakoto</div>
              <div class="pdept">IT · 23 juin → 27 juin</div>
            </div>
          </div>
        </td>
        <td><span class="type-badge t-annuel">Annuel</span></td>
        <td class="td-muted" style="font-size:.8rem">23/06 – 27/06/2025</td>
        <td class="td-mono">5 j</td>
        <td>
          <span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--success);font-weight:500">18 j</span>
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
