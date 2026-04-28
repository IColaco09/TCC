# 📦 Sistema Gerencial — TCC

Sistema web de gestão empresarial desenvolvido em PHP com arquitetura MVC, voltado para o controle de clientes, produtos, pedidos, vendas e usuários.

---

## 🛠️ Tecnologias

- **PHP** — Backend e roteamento
- **MySQL** — Banco de dados
- **HTML/CSS** — Interface
- **JavaScript** — Interações no frontend
- **Apache** — Servidor web (via XAMPP)

---

## 📁 Estrutura do Projeto

```
TCC/
├── app/
│   ├── Controller/
│   │   ├── ControllerHome.php
│   │   ├── ControllerLogin.php
│   │   ├── ControllerUsuarios.php
│   │   ├── ControllerClientes.php
│   │   ├── ControllerProdutos.php
│   │   ├── ControllerVendas.php
│   │   ├── ControllerPedidos.php
│   │   └── ControllerRelatorios.php
│   ├── Model/
│   │   ├── ModelHome.php
│   │   ├── ModelLogin.php
│   │   ├── ModelUsuarios.php
│   │   ├── ModelClientes.php
│   │   ├── ModelProdutos.php
│   │   ├── ModelVendas.php
│   │   ├── ModelPedido.php
│   │   └── ModelRelatorios.php
│   └── View/
│       ├── Home/
│       ├── Login/
│       ├── Usuarios/
│       ├── Clientes/
│       ├── Produtos/
│       ├── Vendas/
│       └── Pedidos/
├── config/
│   ├── Auth.php
│   └── modelbase/
│       └── conexao.php
├── public/
│   ├── Assets/
│   │   ├── css/
│   │   │   ├── Login.css
│   │   │   └── Home.css
│   │   └── js/
│   │       └── rotas.js
│   └── index.php
└── .htaccess
```

---

## ⚙️ Como rodar o projeto

### Pré-requisitos
- [XAMPP](https://www.apachefriends.org/) instalado
- PHP 8.0 ou superior
- MySQL

### Passo a passo

**1. Clone o repositório**
```bash
git clone https://github.com/IColaco09/TCC.git
```

**2. Mova para a pasta do XAMPP**
```
C:/xampp/htdocs/TCC
```

**3. Crie o banco de dados**

Acesse o phpMyAdmin (`http://localhost/phpmyadmin`) e crie um banco chamado `sistemacbs`, depois execute o SQL abaixo:

```sql
CREATE DATABASE sistemacbs;
USE sistemacbs;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  tipo_usuario INT NOT NULL,
  ativo TINYINT DEFAULT 1
);

CREATE TABLE clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  cpf_cnpj VARCHAR(20),
  contato VARCHAR(20),
  ativo TINYINT DEFAULT 1
);

CREATE TABLE produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(50) NOT NULL,
  nome VARCHAR(100) NOT NULL,
  preco DECIMAL(10,2) NOT NULL,
  estoque INT DEFAULT 0,
  tipo INT,
  ativo TINYINT DEFAULT 1
);

CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente_id INT,
  produto VARCHAR(100),
  quantidade INT,
  total DECIMAL(10,2),
  data DATE,
  status VARCHAR(50) DEFAULT 'pendente'
);
```

**4. Crie o usuário admin**
```sql
INSERT INTO usuarios (nome, email, senha, tipo_usuario)
VALUES ('Admin', 'admin@email.com', '$2y$10$HASH_GERADO_PELO_PHP', 1);
```
> Gere o hash com `password_hash('sua_senha', PASSWORD_DEFAULT)` no PHP.

**5. Acesse o sistema**
```
http://localhost/TCC/public/index.php?url=login
```

---

## 🔐 Perfis de Usuário

| Código | Perfil |
|--------|--------|
| 1 | Admin |
| 2 | Gerente |
| 3 | Usuário |

---

## 📌 Funcionalidades

- [x] Login com autenticação segura (`password_hash` / `password_verify`)
- [x] Dashboard com resumo de clientes, produtos e vendas
- [x] Gestão de Usuários (listar, cadastrar, editar, excluir)
- [ ] Gestão de Clientes
- [ ] Gestão de Produtos
- [ ] Gestão de Vendas
- [ ] Gestão de Pedidos
- [ ] Relatórios

---

## 🔒 Segurança

- Senhas armazenadas com `password_hash()`
- Sessões com `cookie_httponly` e `use_only_cookies`
- `session_regenerate_id()` no login
- Proteção contra SQL Injection via `prepared statements`
- Sanitização de output com `htmlspecialchars()`

---

## 👨‍💻 Autor

Desenvolvido por **IColaco09, Natan58, Caio-Guerra, Henzo Malta(Gullit96) entre outros** como projeto de TCC.
