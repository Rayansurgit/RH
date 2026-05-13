<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="data-card">
  <div class="data-card-head">
    <h3>Historique des demandes</h3>
    <div style="display:flex;gap:6px">
      <input type="text" class="f-input" placeholder="Rechercher..." style="width:200px;padding:6px 10px;font-size:.8rem"/>
      <select class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto">
        <option>Tous les statuts</option>
        <option>Approuvées</option>
        <option>Refusées</option>
      </select>
    </div>
  </div>
  <table class="tbl">
    <thead>
      <tr><th>Employé</th><th>Type</th><th>Période</th><th>Durée</th><th>Statut</th><th>Traité le</th><th>Par</th></tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <div class="profile-row">
            <div class="avatar av-green" style="width:32px;height:32px;font-size:.7rem">SR</div>
            <div class="profile-info">
              <div class="pname">Soa Rakoto</div>
              <div class="pdept">IT</div>
            </div>
          </div>
        </td>
        <td><span class="type-badge t-annuel">Annuel</span></td>
        <td class="td-muted" style="font-size:.8rem">16/06 – 20/06/2025</td>
        <td class="td-mono">5 j</td>
        <td><span class="statut s-approuvee">approuvée</span></td>
        <td class="td-muted" style="font-size:.78rem">15 juin 2025</td>
        <td class="td-muted" style="font-size:.78rem">Marie R.</td>
      </tr>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
