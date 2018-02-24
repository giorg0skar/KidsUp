create database KidsUp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

create table Parent
(
     ParEmail VARCHAR(100) not null,
     pwd VARCHAR(100) not null,
     firstname VARCHAR(100) not null,
     lastname VARCHAR(100) not null,
     town VARCHAR(100) not null,
     streetName VARCHAR(100) not null,
     streetNumber smallint unsigned not null,
     PostalCode int,
     PhoneNumber bigint unsigned not null,
     latitude decimal(7,5) not null,
     longitude decimal(7,5) not null,
     Points int,
     online bit(1) not null,
     activated bit(1) not null,
     token VARCHAR(25),
     primary key(ParEmail),
     check ((PostalCode between 0 and 99999) and PhoneNumber > 1999999999)
);

create table Provider
(
     ProvEmail VARCHAR(100) not null,
     pwd VARCHAR(100) not null,
     companyName VARCHAR(100) not null,
     town VARCHAR(100) not null,
     streetName VARCHAR(100) not null,
     streetNumber smallint unsigned not null,
     PostalCode int,
     PhoneNumber bigint unsigned not null,
     VAT bigint unsigned not null,
     CompanyDescription text,
     IBAN bigint unsigned not null,
     online bit(1) not null,
     activated bit(1) not null,
     token VARCHAR(25),
     primary key(ProvEmail),
     check ((PostalCode between 0 and 99999) and PhoneNumber > 1999999999)
);

create table Admin
(
     email VARCHAR(100) not null,
     pwd VARCHAR(100) not null,
     firstname VARCHAR(100) not null,
     lastname VARCHAR(100) not null,
     town VARCHAR(100) not null,
     streetName VARCHAR(100) not null,
     streetNumber smallint unsigned not null,
     PostalCode int,
     PhoneNumber bigint unsigned not null,
     online bit(1) not null,
     primary key(email),
     check ((PostalCode between 0 and 99999) and PhoneNumber > 1999999999)    
);

create table Activity
(
    ActID serial,
    ProvEmail VARCHAR(100) not null,
    actName VARCHAR(100) not null,
    actType VARCHAR(100) not null,
    actDate datetime not null,
    price smallint unsigned not null,
    MinAge smallint unsigned not null,
    MaxAge smallint unsigned not null,
    maxTickets int unsigned not null,
    availableTickets int unsigned not null,
    town VARCHAR(100) not null,
    streetName VARCHAR(100) not null,
    streetNumber smallint unsigned not null,
    PostalCode int,
    PhoneNumber bigint unsigned not null,
    latitude decimal(7,5) not null,
    longitude decimal(7,5) not null,
    actDescription text not null,
    pictureURL VARCHAR(1024),
    visits int unsigned,
    primary key(ActID),
    foreign key(ProvEmail) references Provider(ProvEmail),
    check ((PostalCode between 0 and 99999) and PhoneNumber > 1999999999 and MinAge > 0 and MaxAge < 18)    
);

create table Sell
(
    SellID serial not null,
    ParEmail VARCHAR(100) not null,
    ActID bigint unsigned not null,
    SellDate datetime not null,
    numberofTickets int unsigned not null,
    totalCost int unsigned not null,
    primary key(SellID),
    foreign key(ParEmail) references Parent(ParEmail),
    foreign key(ActID) references Activity(ActID)        
);
