<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="data-card">
  <div class="data-card-head">
    <h3>Soldes des employés - 2025</h3>
    <div style="display:flex;gap:6px">
      <select class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto">
        <option>Tous les départements</option>
        <option>IT</option>
        <option>Finance</option>
        <option>Marketing</option>
      </select>
    </div>
  </div>
  <table class="tbl">
    <thead>
      <tr><th>Employé</th><th>Département</th><th>Annuel</th><th>Maladie</th><th>Spécial</th><th>Total</th></tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <div class="profile-row">
            <div class="avatar av-green" style="width:32px;height:32px;font-size:.7rem">SR</div>
            <div class="profile-info">
              <div class="pname">Soa Rakoto</div>
              <div class="pdept">soa@techmada.mg</div>
            </div>
          </div>
        </td>
        <td class="td-muted">IT</td>
        <td>
          <div class="solde-bar"><div class="solde-fill" style="width:60%;height:8px"></div></div>
          <div style="font-size:.72rem;color:var(--muted);margin-top:2px">18 / 30 j</div>
        </td>
        <td>
          <div class="solde-bar"><div class="solde-fill" style="width:80%;height:8px"></div></div>
          <div style="font-size:.72rem;color:var(--muted);margin-top:2px">8 / 10 j</div>
        </td>
        <td>
          <div class="solde-bar"><div class="solde-fill warn" style="width:20%;height:8px"></div></div>
          <div style="font-size:.72rem;color:var(--muted);margin-top:2px">1 / 5 j</div>
        </td>
        <td class="td-mono" style="font-size:.82rem;color:var(--forest);font-weight:500">27 / 45 j</td>
      </tr>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
