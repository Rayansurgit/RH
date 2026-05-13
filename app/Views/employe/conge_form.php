<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start">

  <!-- Formulaire principal -->
  <div>
    <div class="form-section">
      <h3>Détails de la demande</h3>

      <form method="POST" action="<?= base_url('employe/conges/store') ?>">
        <?= csrf_field() ?>

        <div class="f-group" style="margin-bottom:1rem">
          <label class="f-label">Type de congé <span style="color:var(--danger)">*</span></label>
          <select name="type_conge" class="f-select" required>
            <option value="">-- Choisir un type --</option>
            <?php foreach ($types as $type): ?>
            <option value="<?= $type['id'] ?>"><?= htmlspecialchars($type['libelle']) ?> 
              <?php if (isset($soldes[$type['id']])): ?>
                (<?= $soldes[$type['id']]['restant'] ?> j restants)
              <?php endif; ?>
            </option>
            <?php endforeach; ?>
          </select>
          <?php if ($errors = session('errors')) { ?>
            <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= $errors['type_conge'] ?? '' ?></div>
          <?php } ?>
        </div>

        <div class="form-grid-2" style="margin-bottom:1rem">
          <div class="f-group">
            <label class="f-label">Date de début <span style="color:var(--danger)">*</span></label>
            <input type="date" name="date_debut" class="f-input" value="<?= old('date_debut') ?>" required/>
            <?php if ($errors = session('errors')) { ?>
              <div class="f-error"><?= $errors['date_debut'] ?? '' ?></div>
            <?php } ?>
          </div>
          <div class="f-group">
            <label class="f-label">Date de fin <span style="color:var(--danger)">*</span></label>
            <input type="date" name="date_fin" class="f-input" value="<?= old('date_fin') ?>" required/>
            <?php if ($errors = session('errors')) { ?>
              <div class="f-error"><?= $errors['date_fin'] ?? '' ?></div>
            <?php } ?>
          </div>
        </div>

        <div class="f-computed">
          <div class="f-computed-num" id="jours-count">5</div>
          <div class="f-computed-label">jours calendaires calculés</div>
        </div>

        <div class="f-group" style="margin-bottom:1rem">
          <label class="f-label">Motif (optionnel)</label>
          <textarea name="motif" class="f-textarea" placeholder="Précisez le motif de votre demande si nécessaire..."></textarea>
          <div class="f-hint">Le motif est visible par le responsable RH.</div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-forest"><i class="bi bi-send"></i> Soumettre la demande</button>
          <a href="<?= base_url('employe/dashboard') ?>" class="btn-secondary"><i class="bi bi-x"></i> Annuler</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Panneau latéral : solde & règles -->
  <div style="display:flex;flex-direction:column;gap:1rem">
    <div class="data-card" style="margin:0">
      <div class="data-card-head"><h3><i class="bi bi-piggy-bank" style="color:var(--forest);margin-right:5px"></i>Vos soldes actuels</h3></div>
      <div style="padding:.75rem 1.1rem;display:flex;flex-direction:column;gap:.75rem">
        <?php foreach ($types as $type): ?>
        <?php $balance = $soldes[$type['id']] ?? null; ?>
        <div>
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
            <span style="font-size:.8rem;color:var(--ink)"><?= htmlspecialchars($type['libelle']) ?></span>
            <span style="font-family:'DM Mono',monospace;font-size:.8rem;color:var(--forest);font-weight:500">
              <?= $balance ? $balance['restant'] : 0 ?> j
            </span>
          </div>
          <div class="solde-bar">
            <div class="solde-fill <?= ($balance && $balance['restant'] <= 2) ? 'warn' : '' ?>" 
                 style="width:<?= $balance ? (($balance['restant'] / $type['jours_annuels']) * 100) : 0 ?>%"></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="flash flash-info" style="margin:0">
      <i class="bi bi-info-circle-fill"></i>
      <span style="font-size:.8rem">Le solde est déduit uniquement à l'approbation de votre responsable.</span>
    </div>
    <div style="background:var(--cream);border:1px solid var(--border);border-radius:8px;padding:.85rem 1rem">
      <div style="font-size:.78rem;font-weight:500;color:var(--ink);margin-bottom:.5rem"><i class="bi bi-clipboard-check" style="color:var(--forest);margin-right:5px"></i>Rappel des règles</div>
      <ul style="margin:0;padding-left:1rem;font-size:.75rem;color:var(--muted);line-height:1.7">
        <li>Préavis minimum : 48h avant la date de début</li>
        <li>Pas de chevauchement avec une demande en cours</li>
        <li>Solde insuffisant = demande refusée automatiquement</li>
      </ul>
    </div>
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const dateDebut = document.querySelector('input[name="date_debut"]');
  const dateFin = document.querySelector('input[name="date_fin"]');
  const joursCount = document.getElementById('jours-count');
  
  function calculerJours() {
    if (dateDebut.value && dateFin.value) {
      const debut = new Date(dateDebut.value);
      const fin = new Date(dateFin.value);
      const diffTime = Math.abs(fin - debut);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
      joursCount.textContent = diffDays;
    }
  }
  
  dateDebut.addEventListener('change', calculerJours);
  dateFin.addEventListener('change', calculerJours);
  calculerJours();
});
</script>

<?= $this->endSection() ?>
