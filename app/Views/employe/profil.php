<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="data-card">
  <div class="data-card-head"><h3>Mon profil</h3></div>
  <div style="padding:1.5rem">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem">
      <div>
        <h4 style="font-family:'Playfair Display',serif;font-size:.95rem;margin-bottom:1rem;color:var(--ink)">Informations personnelles</h4>
        <div style="display:flex;flex-direction:column;gap:1rem">
          <div>
            <div style="font-size:.75rem;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Nom complet</div>
            <div style="font-size:.9rem;font-weight:500;color:var(--ink)"><?= session('user_name') ?></div>
          </div>
          <div>
            <div style="font-size:.75rem;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Email</div>
            <div style="font-size:.9rem;font-weight:500;color:var(--ink)"><?= session('user_email') ?></div>
          </div>
          <div>
            <div style="font-size:.75rem;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Rôle</div>
            <div style="font-size:.9rem;font-weight:500;color:var(--ink)">Employé</div>
          </div>
          <div>
            <div style="font-size:.75rem;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Département</div>
            <div style="font-size:.9rem;font-weight:500;color:var(--ink)">IT</div>
          </div>
        </div>
      </div>
      <div>
        <h4 style="font-family:'Playfair Display',serif;font-size:.95rem;margin-bottom:1rem;color:var(--ink)">Sécurité</h4>
        <div style="display:flex;flex-direction:column;gap:.75rem">
          <a href="#" class="btn-secondary" style="justify-content:center"><i class="bi bi-lock"></i> Changer mon mot de passe</a>
          <a href="<?= base_url('auth/logout') ?>" class="btn-secondary" style="justify-content:center;border-color:var(--danger);color:var(--danger)"><i class="bi bi-box-arrow-right"></i> Se déconnecter</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
