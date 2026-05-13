INSERT INTO departments (name, description) VALUES
('Informatique', 'Gestion des systèmes et applications'),
('Ressources Humaines', 'Gestion du personnel');

INSERT INTO type_conge (libelle, jours_annuels, deductible) VALUES
('Congé annuel', 25, 1),
('Congé maladie', 10, 0);

INSERT INTO employees (name, prenom, email, role, date_embauche, actif, id_department, mdp) VALUES
('Rakoto', 'Jean', 'jean.rakoto@gmail.com', 'admin', '2024-01-10', 1, 1, '123456'),
('Rabe', 'Marie', 'marie.rabe@gmail.com', 'rh', '2023-06-15', 1, 2, '123456');

INSERT INTO solde (id_employee, id_type_conge, annee, jours_attribues, jours_pris, restant, pris) VALUES
(1, 1, 2026, 25, 5, 20, 5),
(2, 2, 2026, 10, 2, 8, 2);

INSERT INTO conge (id_employee, id_type_conge, date_debut, date_fin, nb_jours, motif, status, commentaire, traite_par) VALUES
(1, 1, '2026-06-01', '2026-06-05', 5, 'Vacances', 'approuvee', 'OK', 'RH1'),
(2, 2, '2026-07-10', '2026-07-12', 3, 'Maladie', 'en_attente', NULL, NULL);