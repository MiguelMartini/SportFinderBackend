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

## 5 Diagramas
- Diagrama Contexto nível 1
<img width="722" height="522" alt="DiagramaC4" src="https://github.com/user-attachments/assets/1efb1ebd-8a00-434c-a09b-98bc7d953472" />
---------
- Diagrama Container/Visão Lógica
<img width="1102" height="252" alt="DiagramaC4_2" src="https://github.com/user-attachments/assets/5377fb3c-300b-400a-ad61-4eaeef2cca47" />
---------
- Diagrama Entity-RelationShip Diagram
<img width="1132" height="312" alt="DiagramaERDpng" src="https://github.com/user-attachments/assets/d7655f62-7e5e-4e6d-a687-2b1825321778" />

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
3) O usuário seleciona a cidade
4) Sistema mostra no mapa as áreas esportivas
5) O usuário pode selecionar uma área esportiva e visualizar informações, como contato, localidade e características

## 🎨 7. Esboços de tela
<img width="1069" height="610" alt="image" src="https://github.com/user-attachments/assets/3a70b67c-c98e-4c72-a4ef-e567c53c9d39" />
<img width="981" height="571" alt="image" src="https://github.com/user-attachments/assets/1c1dee25-18c2-4360-86ea-068253d5dbe2" />

## 🔧 8. Tecnologias 
### 8.1 Front-End
**HTML/Tailwinds/TypeScript/React.TS**
### 8.2 Back-End
**PHP/Laravel/MYSQL**

## 🎲 9 - Plano de Dados
### 9.1 Entidades
- Usuários: Pessoa que utiliza o sistema (usuário comum/administrador), autentica-se e pode cadastrar ou ver áreas esportivas.
- Áreas Esportivas: Locais na cidade com áreas esportivas.
- Endereços: Relacionados ao usuário

### 9.2 Campos por entidade
Usuário
| Campo      | Tipo         | Obrigatório | Descrição                        |
|------------|--------------|-------------|----------------------------------|
| id         | INT (PK)     | sim         | Identificador único              |
| name       | VARCHAR(255) | sim         | Nome do usuário                  |
| email      | VARCHAR(255) | sim (único) | E-mail do usuário                |
| password   | VARCHAR(255) | sim         | Hash da senha                    |
| phone      | VARCHAR(255) | sim         |                                  |
| role       | TINYINT      | sim         | 0 = comum, 1 = admin             |
| instagram  | VARCHAR(255) | não         | Para divulgação e confiabilidade |
| documento  | VARCHAR(255) | não         | 0 = comum, 1 = admin             |
| city       | VARCHAR(50)  | sim         | Ponto de partida mapa            |
| lat        | VARCHAR(50)  | sim         | Ponto de partida mapa            |
| lon        | VARCHAR(50)  | sim         | Ponto de partida mapa            |
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

Endereços
| Campo      | Tipo         | Obrigatório | Descrição                             |
|------------|--------------|-------------|---------------------------------------|
| id         | INT (PK)     | sim         | Identificador da imagem                |
| rua        | VARCHAR(255)     | sim     | Relaciona-se a areas_esportivas.id     |
| numero     | VARCHAR(255) | sim         |                                        |
| bairro     | VARCHAR(255) | sim         |                                        |
| cidade     | VARCHAR(255) | sim         |                                        |
| estado     | VARCHAR(2) | sim           |                                        |
| cep        | VARCHAR(20) | sim          |                                        |
| complemento| VARCHAR(255) | sim         |                                        |
| area_esportiva_id | VARCHAR(255) | sim | Relaciona-se a areas_esportivas.id      |
| lat        | 	decimal(10,7)| sim        |                                        |
| lat        | 	decimal(10,7)| sim        |                                        |
| created_at | DATETIME     | sim         | Data de criação (default NOW)          |
| updated_at | DATETIME     | sim         | Última atualização (default NOW)       |

## 9.4 Modelagem banco de dados MYSQL
```

CREATE TABLE `areas_esportivas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_administrador` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

CREATE TABLE `enderecos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `lat` decimal(10,7) DEFAULT NULL,
  `lon` decimal(10,7) DEFAULT NULL,
  `area_esportiva_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','usuario') NOT NULL DEFAULT 'usuario',
  `documento` varchar(50) DEFAULT NULL,
  `lat` decimal(10,7) NOT NULL,
  `lon` decimal(10,7) NOT NULL,
  `city` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)


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



