CREATE TABLE employees (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role VARCHAR(50) NOT NULL,
    date_embauche DATE NOT NULL,
    actif BOOLEAN NOT NULL DEFAULT FALSE,
    id_department INT NOT NULL,
    mdp VARCHAR(255) NOT NULL
);

CREATE TABLE conge(
    id SERIAL PRIMARY KEY,
    id_employee INT NOT NULL,
    id_type_conge INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    nb_jours INT NOT NULL,
    motif TEXT,
    status VARCHAR(20) NOT NULL,
    commentaire TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    traite_par  VARCHAR(100),
    FOREIGN KEY (id_employee) REFERENCES employees(id),
    FOREIGN KEY (id_type_conge) REFERENCES type_conge(id)
);

CREATE TABLE type_conge (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL,
    jours_annuels INT NOT NULL,
    deductible BOOLEAN NOT NULL
);

CREATE TABLE departments (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT
);

CREATE TABLE solde(
    id SERIAL PRIMARY KEY,
    id_employee INT NOT NULL,
    id_type_conge INT NOT NULL,
    annee INT NOT NULL,
    jours_attribues INT NOT NULL,
    jours_pris INT NOT NULL,
    restant INT NOT NULL,
    pris INT NOT NULL,
    FOREIGN KEY (id_employee) REFERENCES employees(id),
    FOREIGN KEY (id_type_conge) REFERENCES type_conge(id)
);