create database coachpro;

use coachpro;

create table Sportif (
    id_sportif integer primary key auto_increment,
    sportif_nom varchar(50),
    sportif_prenom varchar(50),
    sportif_email varchar(100),
    sportif_phone varchar(20),
    sportif_password varchar(100),
    sportif_photo varchar(255)
);

create table Coach (
    id_coach integer primary key auto_increment,
    coach_nom varchar(50),
    coach_prenom varchar(50),
    coach_email varchar(100),
    coach_phone varchar(20),
    coach_password VARCHAR(255),
    coach_photo varchar(255),
    coach_biographie varchar(255),
    coach_annees_experiences integer,
    coach_prix integer
);

create table Discipline (
    id_discipline integer primary key auto_increment,
    discipline_nom varchar(50)
);

create table Certificat (
    id_certificat integer primary key auto_increment,
    titre_certificat varchar(100),
    organisme varchar(100),
    annee_certificat date
);

create table Disponibilite (
    id_disponibilite integer primary key auto_increment,
    id_coach integer,
    date_disponibilite date,
    heure_debut time,
    heure_fin time,
    statut varchar(50),
    foreign key (id_coach) references Coach(id_coach)
);

create table Reservation (
    id_reservation integer primary key auto_increment,
    id_sportif integer,
    id_coach integer,
    date_seance date,
    heure_debut time,
    heure_fin time,
    statut varchar(50),
    foreign key (id_sportif) references Sportif(id_sportif),
    foreign key (id_coach) references Coach(id_coach)
);

create table Coach_certificat (
    id_coach integer,
    id_certificat integer,
    primary key (id_coach, id_certificat),
    foreign key (id_coach) references Coach(id_coach),
    foreign key (id_certificat) references Certificat(id_certificat)
);

create table Coach_discipline (
    id_coach integer,
    id_discipline integer,
    primary key (id_coach, id_discipline),
    foreign key (id_coach) references Coach(id_coach),
    foreign key (id_discipline) references Discipline(id_discipline)
);
