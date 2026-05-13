CREATE TABLE departments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    description TEXT
);

CREATE TABLE type_conge (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL,
    jours_annuels INTEGER NOT NULL,
    deductible BOOLEAN NOT NULL
);

CREATE TABLE employees (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    prenom TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    role TEXT NOT NULL,
    date_embauche DATE NOT NULL,
    actif BOOLEAN NOT NULL DEFAULT 0,
    id_department INTEGER NOT NULL,
    mdp TEXT NOT NULL,
    
    FOREIGN KEY (id_department) REFERENCES departments(id)
);

CREATE TABLE conge(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_employee INTEGER NOT NULL,
    id_type_conge INTEGER NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    nb_jours INTEGER NOT NULL,
    motif TEXT,
    status TEXT NOT NULL,
    commentaire TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    traite_par TEXT,

    FOREIGN KEY (id_employee) REFERENCES employees(id),
    FOREIGN KEY (id_type_conge) REFERENCES type_conge(id)
);

CREATE TABLE solde(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_employee INTEGER NOT NULL,
    id_type_conge INTEGER NOT NULL,
    annee INTEGER NOT NULL,
    jours_attribues INTEGER NOT NULL,
    jours_pris INTEGER NOT NULL,
    restant INTEGER NOT NULL,
    pris INTEGER NOT NULL,

    FOREIGN KEY (id_employee) REFERENCES employees(id),
    FOREIGN KEY (id_type_conge) REFERENCES type_conge(id)
);