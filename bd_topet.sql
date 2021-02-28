CREATE TABLE IF NOT EXISTS postagens (
    titulo VARCHAR(128) NOT NULL,
	legenda VARCHAR(600) NOT NULL,
	img TEXT NOT NULL,
	id_postagem serial not null PRIMARY KEY
);