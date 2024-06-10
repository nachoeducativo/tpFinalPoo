CREATE TABLE persona (
    nrodoc varchar(15),
    apellido varchar(150),
    nombre varchar(150),
    email varchar(150),
    PRIMARY KEY (nrodoc)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE responsable (
    rnumeroempleado bigint AUTO_INCREMENT,
    nrodoc varchar(15),
    rnumerolicencia bigint,
    PRIMARY KEY (rnumeroempleado),
    FOREIGN KEY (nrodoc) REFERENCES persona (nrodoc)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, /*codigo de viaje*/
    vdestino varchar(150),
    vcantmaxpasajeros int,
    idempresa bigint,
    rnumeroempleado bigint,
    vimporte float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
    FOREIGN KEY (rnumeroempleado) REFERENCES responsable (rnumeroempleado)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;

CREATE TABLE pasajero (
    nrodoc varchar(15),
    pdocumento varchar(15),
    ptelefono int,
    idviaje bigint,
    PRIMARY KEY (nrodoc),
    FOREIGN KEY (nrodoc) REFERENCES persona (nrodoc),
    FOREIGN KEY (idviaje) REFERENCES viaje (idviaje)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

