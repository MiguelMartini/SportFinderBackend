# 👷 Projetando SportFinder

## 1. Introdução 
 O projeto surgiu da necessidade de pessoas que buscam uma vida mais saudável e daquelas que já possuem uma rotina esportiva. A prática regular de esportes contribui para o bem-estar físico e mental, mas muitas vezes é difícil encontrar locais adequados para essas atividades.
 
 A falta de informação sobre áreas esportivas disponíveis é um obstáculo para quem deseja praticar esportes ao ar livre ou em espaços públicos. A solução proposta é uma aplicação web que exibe áreas esportivas, como quadras de vôlei, basquete, futebol, pistas de corrida, skate, entre outras, facilitando o acesso e incentivando a prática esportiva.


### 1.1 Escopo do Sistema 

O sistema é uma aplicação web destinada aos cadastros de Áreas esportivas, permitindo que os esportistas encontrem locais para praticar esporte na cidade de sua preferência; 

### 1.2 Público-Alvo 

- Atletas e esportistas, que buscam espaços para prática esportiva. 

- Proprietários de Áreas esportivas, que desejam divulgar e fomentar o esporte. 

## 2. Atores
- Usuário Comum: Usuário que busca por informações e consome a aplicação;
- Administrador: Usuário que realiza o cadastro das áreas esportivas;

## 3. Casos de Uso
- Usuário comum: Deslogar/Logar no sistema, manter dados cadastrais;
- Administrador: Manter(listar, mostrar, inserir, editar e remover) as áreas esportivas

## 4. Limites e Suposições
- Limites: Entregar o projeto até o fim da disciplina; Rodar no navegador; Sem custos de serviços;
- Suposições: internet no laboratório; navegador atualizado; acesso ao GitHub; 10 min para teste rápido.

## 5
## 6. Fluxos
**Fluxo administrador**

1) Administrador acessa o sistema e realiza o cadastro
2) O Administrador realiza Login no sistema
3) O administrador insere informações da área esportiva
4) O sistema valida e armazena os dados cadastrados
5) O administrador pode editar ou remover áreas cadastradas

**Fluxo Usuário**
1) O usuário Comum acessa o sistema
2) O usuário realiza o cadastro/login no sistema
3) O usuário seleciona a cidade ou usa filtros de pesquisa
4) Sistema mostra no mapa as áreas esportivas de acordo com as preferências do usuário
5) O usuário pode selecionar uma área esportiva e visualizar informações, como contato, localidade e características

## 🎨 7. Esboços de tela
<img width="1069" height="610" alt="image" src="https://github.com/user-attachments/assets/3a70b67c-c98e-4c72-a4ef-e567c53c9d39" />
<img width="981" height="571" alt="image" src="https://github.com/user-attachments/assets/1c1dee25-18c2-4360-86ea-068253d5dbe2" />

## 🔧 8. Tecnologias 
### 8.1 Front-End
**HTML/Tailwinds/JavaScript/React.JS**
### 8.2 Back-End
**PHP/Laravel/Inertia/MYSQL**

## 🎲 9 - Plano de Dados
### 9.1 Entidades
- Usuários: Pessoa que utiliza o sistema (usuário comum/administrador), autentica-se e pode cadastrar ou ver áreas esportivas.
- Áreas Esportivas: Locais na cidade com áreas esportivas.
- Comentários: Comentários de usuários comuns nas áreas esportivas.
- Imagens área: Imagens contidas nas áreas esportivas.

### 9.2 Campos por entidade
Usuário
| Campo      | Tipo         | Obrigatório | Descrição                        |
|------------|--------------|-------------|----------------------------------|
| id         | INT (PK)     | sim         | Identificador único              |
| nome       | VARCHAR(255) | sim         | Nome do usuário                  |
| email      | VARCHAR(255) | sim (único) | E-mail do usuário                |
| senha      | VARCHAR(255) | sim         | Hash da senha                    |
| perfil     | TINYINT      | sim         | 0 = comum, 1 = admin             |
| documento  | VARCHAR(50)  | não         | CPF ou CNPJ                      |
| created_at | DATETIME     | sim         | Data de criação (default NOW)    |
| updated_at | DATETIME     | sim         | Última atualização (default NOW) |


Áreas esportivas
| Campo           | Tipo         | Obrigatório | Descrição                              |
|-----------------|--------------|-------------|----------------------------------------|
| id              | INT (PK)     | sim         | Identificador da área esportiva        |
| id_administrador| INT (FK)     | sim         | Relaciona-se a usuarios.id             |
| titulo          | VARCHAR(255) | sim         | Nome/título da área                    |
| descricao       | VARCHAR(500) | não         | Descrição da área                      |
| endereco        | VARCHAR(255) | não         | Endereço                               |
| cidade          | VARCHAR(80)  | não         | cidade                                 |
| cep             | VARCHAR(20)  | não         | CEP da área                            |
| nota            | TINYINT      | não         | Avaliação (0 a 5)                      |
| created_at      | DATETIME     | sim         | Data de criação (default NOW)          |
| updated_at      | DATETIME     | sim         | Última atualização (default NOW)       |


Comentários
| Campo      | Tipo         | Obrigatório | Descrição                             |
|------------|--------------|-------------|---------------------------------------|
| id         | INT (PK)     | sim         | Identificador do comentário            |
| id_usuario | INT (FK)     | sim         | Relaciona-se a usuarios.id             |
| id_area    | INT (FK)     | sim         | Relaciona-se a areas_esportivas.id     |
| titulo     | VARCHAR(255) | não         | Título do comentário                   |
| texto      | VARCHAR(500) | não         | Texto do comentário                    |
| nota       | TINYINT      | não         | Avaliação atribuída                    |
| created_at | DATETIME     | sim         | Data de criação (default NOW)          |
| updated_at | DATETIME     | sim         | Última atualização (default NOW)       |

Imagens das áreas
| Campo      | Tipo         | Obrigatório | Descrição                             |
|------------|--------------|-------------|---------------------------------------|
| id         | INT (PK)     | sim         | Identificador da imagem                |
| id_area    | INT (FK)     | sim         | Relaciona-se a areas_esportivas.id     |
| caminho    | VARCHAR(500) | sim         | Caminho/URL da imagem                  |
| created_at | DATETIME     | sim         | Data de criação (default NOW)          |
| updated_at | DATETIME     | sim         | Última atualização (default NOW)       |

## 9.4 Modelagem banco de dados MYSQL
```
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil SMALLINT NOT NULL, -- 'comum = 0' ou 'admin = 1'
    documento VARCHAR(50), 
    created_at TIMESTAMP DEFAULT NOW() NOT NULL,
    updated_at TIMESTAMP DEFAULT NOW() NOT NULL
);

CREATE TABLE areas_esportivas (
    id SERIAL PRIMARY KEY,
    id_administrador INT NOT NULL REFERENCES usuarios(id),
    titulo VARCHAR(255) NOT NULL,
    descricao VARCHAR(500),
    endereco VARCHAR(255),
    cidade VARCHAR(80),
    cep VARCHAR(20),
    nota SMALLINT, -- de 0 a 5
    created_at TIMESTAMP DEFAULT NOW() NOT NULL,
    updated_at TIMESTAMP DEFAULT NOW() NOT NULL
);

CREATE TABLE comentarios (
    id SERIAL PRIMARY KEY,
    id_usuario INT NOT NULL REFERENCES usuarios(id),
    id_area INT NOT NULL REFERENCES areas_esportivas(id),
    titulo VARCHAR(255),
    texto VARCHAR(500),
    nota SMALLINT,
    created_at TIMESTAMP DEFAULT NOW() NOT NULL,
    updated_at TIMESTAMP DEFAULT NOW() NOT NULL
);

CREATE TABLE imagens_area (
    id SERIAL PRIMARY KEY,
    id_area INT NOT NULL REFERENCES areas_esportivas(id),
    caminho VARCHAR(500) NOT NULL,
    created_at TIMESTAMP DEFAULT NOW() NOT NULL,
    updated_at TIMESTAMP DEFAULT NOW() NOT NULL
);


-- Inserindo usuários
INSERT INTO usuarios (nome, email, senha, perfil, documento)
VALUES
('Miguel Silva', 'miguel@email.com', '123456', 1, '12345678900'),
('Ana Souza', 'ana@email.com', 'abcdef', 0, '98765432100'),
('Carlos Pereira', 'carlos@email.com', 'pass123', 0, '11223344556');

-- Inserindo áreas esportivas
INSERT INTO areas_esportivas (id_administrador, titulo, descricao, endereco, cep, nota)
VALUES
(1, 'Academia Alpha', 'Academia completa com musculação e crossfit', 'Rua A, 123', '12345-678', 5),
(1, 'Quadra Beta', 'Quadra poliesportiva coberta', 'Rua B, 456', '23456-789', 4),
(1, 'Piscina Gamma', 'Piscina olímpica e aquecimento', 'Rua C, 789', '34567-890', 5);

-- Inserindo comentários
INSERT INTO comentarios (id_usuario, id_area, titulo, texto, nota)
VALUES
(2, 1, 'Excelente Academia', 'Gostei muito da estrutura e dos professores', 5),
(3, 1, 'Bom Atendimento', 'A equipe foi prestativa, mas os equipamentos poderiam ser mais modernos', 4),
(2, 2, 'Ótima Quadra', 'Ideal para jogos de vôlei e futsal', 5);

-- Inserindo imagens
INSERT INTO imagens_area (id_area, caminho)
VALUES
(1, '/imagens/alpha1.jpg'),
(1, '/imagens/alpha2.jpg'),
(2, '/imagens/beta1.jpg');

SELECT a.id, a.titulo, u.nome AS administrador
FROM areas_esportivas a
JOIN usuarios u ON a.id_administrador = u.id;


SELECT c.titulo, c.texto, c.nota, u.nome AS usuario
FROM comentarios c
JOIN usuarios u ON c.id_usuario = u.id
WHERE c.id_area = 1;


SELECT titulo, descricao, nota
FROM areas_esportivas
WHERE nota >= 5;


SELECT a.titulo AS area, i.caminho AS imagem
FROM imagens_area i
JOIN areas_esportivas a ON i.id_area = a.id;


SELECT a.titulo, COUNT(c.id) AS total_comentarios
FROM areas_esportivas a
LEFT JOIN comentarios c ON a.id = c.id_area
GROUP BY a.titulo;

SELECT ROUND(AVG(nota),1) FROM comentarios


```



