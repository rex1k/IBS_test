create table if not exists vendors
(
    id int primary key auto_increment not null,
    name varchar(100) not null unique
);

create table if not exists models
(
    id int primary key not null auto_increment,
    name varchar(200) not null unique,
    vendor_id int not null,
    foreign key vendor (vendor_id) references vendors(id) on delete cascade
);

create table if not exists laptops
(
    id int primary key not null auto_increment,
    name varchar(200) not null unique,
    year date not null,
    price float(12, 2) not null,
    model_id int not null,
    foreign key model (model_id) references models(id) on delete cascade
);

create table if not exists options
(
    id int primary key not null auto_increment,
    name varchar(100) not null
);

create table if not exists option_relations
(
    id int primary key not null auto_increment,
    LAPTOP_id int not null,
    OPTIONS_id int not null,
    foreign key laptop_fk (LAPTOP_id) references laptops(id),
    foreign key option_fk (OPTIONS_id) references options(id)
);